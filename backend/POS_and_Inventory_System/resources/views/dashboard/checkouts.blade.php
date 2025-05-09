@extends('layouts.dashboard')

@section('title', 'Checkouts')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-checkouts.css') }}">
@endsection

@section('content')
<div class="wrapper2">

    <h1>Checkouts</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="checkouts">

        <div class="checkouts-tab">

            <div class="checkout-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="products-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button id="addButton" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">New</button>

            </div>

        </div>

        <div class="checkouts-table">

            <table class="table table-hover products">

                <thead>
                    <tr>
                        <th class="table-row">Date/Time</th>
                        <th class="table-row">Product</th>
                        <th class="table-row">Quantity</th>
                        <th class="table-row">Price</th>
                        <th class="table-row">Total</th>
                        <th class="table-row">Cashier</th>
                        <th class="table-row d-none action-column" scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="checkouts-table-body">
                    @forelse ($checkouts as $checkout)
                    <tr>
                        <td class="table-data">{{ $checkout->created_at->format('Y-m-d H:i') }}</td>
                        <td class="table-data">{{ $checkout->product_qty }}</td>
                        <td class="table-data">
                            @php
                                $product = $checkout->product;
                                $productImage = $product->product_image && Storage::disk('public')
                                    ->exists($product->product_image)
                                    ? Storage::url($product->product_image)
                                    : asset('storage/defaults/product_image.png');
                            @endphp
                            <span class="product-image">
                                <img src="{{ $productImage }}" alt="Product" width="40" height="40" style="object-fit: cover;">
                            </span>
                            <span class="product-name">
                                {{ $product->product_name }}
                            </span>
                        </td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center fw-bold">No checkouts found.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tbody id="no-results" style="display: none;">
                    <tr>
                        <td colspan="9" class="text-center fw-bold">No results found.</td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    // Check if there are validation errors and reopen the modal
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            var newModal = new bootstrap.Modal(document.getElementById('new-modal'));
            newModal.show();
        });
    @endif
</script>
@endsection