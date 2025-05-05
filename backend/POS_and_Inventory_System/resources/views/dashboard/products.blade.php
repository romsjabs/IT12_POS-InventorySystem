@extends('layouts.master')

@section('title', 'Products')

@include('partials.dashboard-menu')

@section('content')
<div class="wrapper2">

    <h1>Products</h1>

    <div class="products">

        <div class="products-tab">

            <div class="product-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="session-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">New</button>
                <button type="button" class="btn btn-secondary btn-sm">Edit</button>
                <button type="button" class="btn btn-secondary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm">Delete</button>

            </div>

        </div>

        <div class="products-table">

            <table class="table table-hover products">

                <thead>
                    <tr>
                        <th scope="col">Date added</th>
                        <th scope="col">Product SKU/ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                        <td>{{ $product->product_sku_id ?? 'N/A' }}</td>
                        <td>
                            <span class="product-image">
                                <img src="{{ asset('assets/img/product_image.png') }}" alt="Product Image" width="50" height="50">
                            </span>
                            <span class="product-name">
                                {{ $product->product_name }}
                            </span>
                        </td>
                        <td>{{ $product->product_category }}</td>
                        <td>₱ {{ number_format($product->product_price) }}</td>
                        <td>x {{ $product->product_stock }}</td>
                        <td>

                            @if ($product->product_stock > 0)

                                <div class="in-stock">

                                    <span>
                                        <i class="fa-solid fa-circle"></i>
                                    </span>

                                    <span>
                                        In stock
                                    </span>

                                </div>

                            @else
        
                                <div class="out-of-stock">

                                    <span>
                                        <i class="fa-solid fa-xmark"></i>
                                    </span>

                                    <span>
                                        Out of stock
                                    </span>

                                </div>

                            @endif
                        </td>

                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection

@include('dashboard.modals.product')