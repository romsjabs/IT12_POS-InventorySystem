@extends('layouts.guest')

@section('title', 'Register')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style-register.css') }}">
@endsection

@section('content')
<div class="wrapper1">

    @if($errors->any())
        <div class="auth-error">
        
            <div class="auth-error-wrapper">

                <div class="auth-error-message">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
                
            </div>

        </div>
    @endif

    <div class="registration">
        
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="registration-title">

                <h3 class="title">Register</h3>
                <p class="description">Please fill in the form below to create an account.</p>

            </div>

            <hr>

            <div class="reg-container1">

                <div class="row g-1">

                    <div class="firstname form-floating mb-1 col-md-6">
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name">
                        <label for="firstname">First name</label>
                    </div>

                    <div class="middlename form-floating col-md-6">
                        <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middle name">
                        <label for="middlename">Middle name</label>
                    </div>

                </div>

                <div class="row g-1 mt-1">

                    <div class="lastname form-floating mb-1 col-md-6">
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name">
                        <label for="lastname">Last name</label>
                    </div>

                    <div class="extension form-floating col-md-6">

                        <select name="extension" id="extension" class="form-select" placeholder="Extension">
                            <option value="" selected>N/A</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                        </select>
                        <label for="extension">Extension</label>

                    </div>
                    
                </div>

                <div class="row g-1 mt-1">

                    <div class="gender form-floating mb-1 col-md-6">

                        <select name="gender" id="gender" class="form-select" placeholder="Gender">
                            <option selected disabled>Select..</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <label for="gender">Gender</label>

                    </div>

                    <div class="birthdate form-floating col-md-6">
                        <input type="date" name="birthdate" id="birthdate" class="form-control" placeholder="Birthdate">
                        <label for="birthdate">Birthdate</label>
                    </div>

                </div>
                
            </div>

            <hr>

            <div class="reg-container2 mt-2">

                <div class="row g-1">

                    <div class="username form-floating mb-1 col-md-12">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                        <label for="username">Username</label>
                    </div>

                    <div class="email-address form-floating mb-1 col-md-12">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                        <label for="email">Email address</label>
                    </div>

                </div>

                <div class="row g-1 mt-0">

                    <div class="password form-floating mb-1 col-md-6">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <label for="password">Password</label>
                    </div>

                    <div class="confirm-password form-floating mb-1 col-md-6">
                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control" placeholder="Confirm password">
                        <label for="confirm-password">Confirm password</label>
                    </div>

                </div>

            </div>

            <hr>

            <div class="reg-container3 mt-2">

                <button class="btn btn-primary signup-btn">
                    
                    <span>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </span>

                    <span>
                        Sign up
                    </span>
                    
                </button>
                
            </div>

        </form>

    </div>

</div>
@endsection