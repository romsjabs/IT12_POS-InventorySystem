@extends('layouts.dashboard')

@section('title', 'Products')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-products.css') }}">
@endsection

@section('content')
<div class="wrapper2">

    <h1>Products</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="products">

        <div class="products-tab">

            <div class="product-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="products-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button id="addButton" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">New</button>
                @if ($products->count() > 0)
                    <button id="editButton" type="button" class="btn btn-secondary btn-sm">Edit</button>
                    <button id="cancelButton" type="button" class="btn btn-secondary btn-sm d-none">Cancel</button>
                @endif

            </div>

        </div>

        <div class="products-table">

            <table class="table table-hover products">

                <thead>
                    <tr>
                        <th class="table-row" scope="col">Date added</th>
                        <th class="table-row" scope="col">Product ID</th>
                        <th class="table-row" scope="col">Product Name</th>
                        <th class="table-row" scope="col">Category</th>
                        <th class="table-row" scope="col">Price</th>
                        <th class="table-row" scope="col">Stock</th>
                        <th class="table-row" scope="col">Status</th>
                        <th class="table-row d-none action-column" scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="products-table-body">
                    @forelse ($products as $product)
                    <tr>
                        <td class="table-data">{{ $product->created_at->format('Y-m-d') }}</td>
                        <td class="table-data">{{ $product->product_id ?? 'N/A' }}</td>
                        <td class="table-data">
                            @php
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
                        <td class="table-data">{{ $product->product_category }}</td>
                        <td class="table-data">₱ {{ number_format($product->product_price, 2) }}</td>
                        <td class="table-data">x {{ $product->product_stock }}</td>
                        <td class="table-data">

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
                        <td class="table-data d-none action-column">
                            <div class="action-buttons">
                                <!-- Edit Product Button -->
                                <button type="button" class="btn btn-primary btn-sm edit-product" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" data-productid="{{ $product->product_id }}" data-category="{{ $product->product_category }}" data-price="{{ $product->product_price }}" data-stock="{{ $product->product_stock }}" data-image="{{ $product->product_image && Storage::disk('public')->exists($product->product_image) ? Storage::url($product->product_image) : asset('storage/defaults/product_image.png') }}" data-bs-toggle="modal" data-bs-target="#edit-modal">
                                    Edit
                                </button>
                                <!-- Delete Product Button -->
                                <button 
                                    type="button" 
                                    class="btn btn-danger btn-sm delete-product" 
                                    data-id="{{ $product->id }}" 
                                    data-name="{{ $product->product_name }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal">
                                    Delete
                                </button>
                            </div>
                        </td>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center fw-bold">No products found</td>
                        </tr>
                        @endforelse

                    </tr>
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

@include('dashboard.modals.products.add')
@include('dashboard.modals.products.edit')
@include('dashboard.modals.products.delete')

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
