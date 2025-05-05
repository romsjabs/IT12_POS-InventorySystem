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
                    <tr>
                        <td>2025-01-01</td>
                        <td>4-800020-021112</td>
                        <td>

                            <span class="product-image">
                                <img src="assets/img/product_image.png" alt="Product Image" width="50" height="50">
                            </span>

                            <span class="product-name">
                                Product 1
                            </span> 

                        </td>
                        <td>unspecified</td>
                        <td>
                            <span>₱</span>
                            <span>0.00</span>
                        </td>
                        <td>
                            <span>x</span>
                            <span>0</span>
                        </td>
                        <td>

                            <div class="in-stock">

                                <span>
                                    <i class="fa-solid fa-circle"></i>
                                </span>
                                
                                <span>
                                    In stock
                                </span>

                            </div>

                            <div class="out-of-stock">

                                <span>
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                                
                                <span>
                                    Out of stock
                                </span>

                            </div>

                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection