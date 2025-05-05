@extends('layouts.master')

@section('title', 'Details')

@include('partials.dashboard-menu')

@section('content')
<div class="wrapper2">

    <h1>Details</h1>

    <div class="protip">

        <div class="protip-wrapper">

            <div class="protip-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            
            <div class="protip-msg">
                Since you're new here, please fill out the details, otherwise the default details will be used during receipt printing.
            </div>

        </div>

    </div>

    <div class="details">

        <div class="est-name">

            <label for="est-name" class="form-label">

                <span>
                    <i class="fa-solid fa-building-columns"></i>
                </span>
                
                <span>
                    Establishment name
                </span>

            </label>

            <input type="text" name="est-name" id="est-name" class="form-control" placeholder="RJC Industries, Inc." required>

        </div>

        <div class="est-address">

            <label for="est-address" class="form-label">

                <span><i class="fa-solid fa-location-dot"></i></span>
                <span>Establishment address</span>

            </label>

            <textarea class="form-control" name="est-address" id="est-address" rows="3" placeholder="123 Makabugto Drive, Ma-a, Davao City"></textarea>

        </div>

        <div class="est-contact-number">

            <label for="est-contact-number" class="form-label">

                <span>
                    <i class="fa-solid fa-phone"></i>
                </span>
                
                <span>Contact number</span>

            </label>

            <input type="text" name="est-contact-number" id="est-contact-number" class="form-control" placeholder="09123456789" required>

        </div>

        <div class="est-tin-number">

            <label for="est-tin-number" class="form-label">

                <span>
                    <i class="fa-solid fa-id-card"></i>
                </span>
                
                <span>TIN number</span>

            </label>

            <input type="text" name="est-tin-number" id="est-tin-number" class="form-control" placeholder="123-456-789" required>

        </div>

    </div>

    <div class="buttons">

        <button type="button" class="btn btn-primary" id="save-details">Save</button>
        <button type="button" class="btn btn-secondary" id="cancel-details">Cancel</button>

    </div>

</div>
@endsection