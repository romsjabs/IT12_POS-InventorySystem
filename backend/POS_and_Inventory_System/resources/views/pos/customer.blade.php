@extends('layouts.pos')

@section('title', 'POS Customer View')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/pos-customer.css')}}">
@endsection

@section('content')
    <div class="wrapper1">

        <div class="products-list">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>

        </div>

        <div class="details-wrapper">

            <div class="current-item d-none" id="customer-product-details">
    
            </div>
    
            <div class="welcome-user" id="welcome-customer">
    
                <h1>Welcome, Customer!</h1>
    
            </div>

            <!--

            <div class="rewards-card">

                <span>
                    <h1>Rewards card scanned!</h1>
                </span>
                
                <span>
                    <h4>Expiry date:</h4>
                    <h4>January 01, 2025</h4>
                </span>
                
            </div>

            !-->

        </div>

    </div>

    <div class="wrapper2">

        <div class="est-logo">

            <div class="establishment-logo">
                ESTABLISHMENT LOGO<br>
                (290 x 124)
            </div>

        </div>

        <div class="banner-ad">

            <div class="sample-banner-ad">
                BANNER ADVERTISEMENT<br>
                (290 x 370)
            </div>
        
        </div>
        
        <div class="checkout-details">

            <div class="checkout1 d-none" id="checkout1">

            </div>

            <div class="checkout2 d-none" id="checkout2">

            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/pos-customer.js')}}"></script>
@endsection
