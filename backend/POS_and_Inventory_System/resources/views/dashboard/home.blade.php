@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard.css') }}">
@endsection

@section('content')

<div class="wrapper2">

    <h1>Home</h1>

    <div class="container1">

        <div class="card-wrapper1">
        
            <div class="card-count">

                <div class="card-header">
                    <h4>Sales</h4>
                    <i class="fa-solid fa-money-bills" style="color: #212529"></i>
                </div>

                <div class="card-body">
                    <h1>{{ number_format($salesCount) }}</h1>
                </div>

            </div>

            <div class="card-count">

                <div class="card-header">
                    <h4>Checkouts</h4>
                    <i class="fa-solid fa-cart-shopping" style="color: #212529"></i>
                </div>

                <div class="card-body">
                    <h1>0</h1>
                </div>

            </div>

        </div>

        <div class="card-wrapper2">

            <div class="card-count">

                <div class="card-header">
                    <h4>Products</h4>
                    <i class="fa-solid fa-bag-shopping" style="color: #212529"></i>
                </div>

                <div class="card-body">
                    <h1>{{ number_format($productsCount) }}</h1>
                </div>

            </div>

            <div class="card-count">

                <div class="card-header">
                    <h4>Users</h4>
                    <i class="fa-solid fa-users" style="color: #212529"></i>
                </div>

                <div class="card-body">
                    <h1>0</h1>
                </div>

            </div>

        </div>

    </div>

    <div class="container2">

        <div class="daily-sales">

            <canvas id="Sales" width="400" height="200"></canvas>

        </div>

        <div class="monthly-sales">

            <canvas id="monthlySales" width="400" height="200"></canvas>

        </div>

    </div>

    <div class="container3">

        <div class="recent-checkouts">

            <h5>Recent Checkouts</h5>

            <div class="checkouts-table">

                <table class="table table-hover checkouts">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Total</th>
                            <th scope="col">Cashier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-01-01</td>
                            <td>PHP 500</td>
                            <td>x10</td>
                            <td>Romar Jabez</td>
                        </tr>
                        <tr>
                            <td>2025-01-01</td>
                            <td>PHP 500</td>
                            <td>x10</td>
                            <td>Romar Jabez</td>
                        </tr>
                    </tbody>
                </table>

                <div class="view-all">
                    <span><i class="fa-solid fa-arrow-right"></i></span>
                    <span>View all...</span>
                </div>

            </div>
            
        </div>

        <div class="recent-products">

            <h5>Recently added Products</h5>

            <div class="products-table">

                <table class="table table-hover products">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Product</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td class="table-data">
                                {{ $product->created_at->format('Y-m-d') }}
                            </td>
                            <td class="table-data">
                                {{ $product->product_name }}
                            </td>
                            <td class="table-data">
                                x{{ $product->product_stock }}
                            </td>
                            <td class="table-data">
                                ₱ {{ number_format($product->product_price, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center fw-bold">
                                No products found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="view-all">
                    <span><i class="fa-solid fa-arrow-right"></i></span>
                    <span>View all...</span>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection