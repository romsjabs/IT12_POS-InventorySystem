@extends('layouts.pos')

@section('title', 'POS Cashier View')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/pos-cashier.css')}}">
@endsection

@push('header')
    @include('partials.pos.header')
@endpush

@section('content')
    <!-- Products -->

    <div class="wrapper1">

        <div class="item-buttons">

            <div class="item-button">

                <span><i class="inventory-icon fa-solid fa-border-all"></i></span>
                <span class="inventory-label">All</span>

            </div>

            <div class="item-button">

                <span><i class="fa-solid fa-layer-group"></i></span>
                <span class="inventory-label">Category</span>

            </div>

            <div class="item-button">

                <span><i class="fa-solid fa-layer-group"></i></span>
                <span class="inventory-label">Category</span>

            </div>

        </div>

    </div>

    <div class="wrapper2">
        
        <div class="inventory-list">

            <div class="inventory-search">

                <span>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>

                <input type="search" id="products-search" name="search" placeholder="Search..">

            </div>

            <div class="items-wrapper">

                @forelse ($products as $product)

                    <div class="item" onclick="addToOrder({{ $product->id }})">

                        <img id="item-image" 
                        src="{{ $product->product_image && Storage::disk('public')->exists($product->product_image) 
                            ? Storage::url($product->product_image) 
                            : asset('storage/defaults/product_image.png') 
                        }}"
                        alt="Product Image">

                        <span class="item-name">{{ $product->product_name }}</span>

                        @if ($product->product_stock <= 0)
                            <div class="stock-label">
                                Not Available
                            </div>
                        @endif

                    </div>

                    @empty
                    <div class="no-items">
                        No items found.
                    </div>
                    
                @endforelse

            </div>

        </div>

    </div>

    <!-- Transactions -->

    <div class="wrapper3">

        <div class="container1">

            <div class="products-list">

                <table class="table" id="orders-table">
                    <thead>
                        <tr>
                            <th scope="col">Product SKU/ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

            </div>

        </div>

        <div class="container2">

            <div class="pos-wrapper1">

                <div class="reference">

                    <h4>Ref:</h4>
                    <h4>0000000000</h4>

                </div>

                <div class="screen">
                    ₱ 0.00
                </div>

                <div class="amount">

                    <div class="amount1">

                        <div class="change">
    
                            <h4>Change:</h4>
                            <h4>₱ 0.00</h4>
        
                        </div>
    
                    </div>
    
                    <div class="amount2">
    
                        <div class="subtotal">
    
                            <h4>Subtotal:</h4>
                            <h4>₱ 0.00</h4>
    
                        </div>
    
                        <div class="discount">
    
                            <h4>Discount:</h4>
                            <h4>₱ 0.00</h4>
    
                        </div>
    
                        <div class="grand-total">
    
                            <h3>Grand Total:</h3>
                            <h1>₱ 10,000.00</h1>
    
                        </div>
    
                    </div>

                </div>

            </div>

            <div class="pos-wrapper2">

                <div class="numpad">

                    <div class="numpad-buttons">

                        <div class="numpad-wrapper1">

                            <h1 class="numpad-key" onclick="addDigit('7')">7</h1>
                            <h1 class="numpad-key" onclick="addDigit('8')">8</h1>
                            <h1 class="numpad-key">9</h1>

                        </div>

                        <div class="numpad-wrapper2">

                            <h1 class="numpad-key">4</h1>
                            <h1 class="numpad-key">5</h1>
                            <h1 class="numpad-key">6</h1>

                        </div>

                        <div class="numpad-wrapper3">

                            <h1 class="numpad-key">1</h1>
                            <h1 class="numpad-key">2</h1>
                            <h1 class="numpad-key">3</h1>

                        </div>

                        <div class="numpad-wrapper4">

                            <h1 class="numpad-key">0</h1>
                            <h1 class="numpad-key clear">C</h1>
                            <h1 class="numpad-key enter"><i class="fa-solid fa-right-to-bracket"></i></h1>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection