@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="wrapper1">

    <div class="container1">

        <div class="introduction">
    
            <h2 class="intro1">Introducing</h2>

            <span class="intro2">
                <h1>Point-of-Sale</h1>
                <h2>&</h2>
            </span>
            
            <span class="intro3">
                <h1>Inventory</h1>
                <h1>System</h1>
            </span>

        </div>

        <div class="description">
            A fast and lightweight POS and Inventory System that is perfect for small to medium businesses.
        </div>

    </div>

    <div class="container2">
        
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="cred-wrapper1">

                <div class="form-floating">
                    <input type="text" name="username_email" id="username-email" class="form-control" placeholder="Email or Username">
                    <label for="username-email">Email or Username</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <label for="password">Password</label>
                </div>

            </div>

            <div class="cred-wrapper2">

                <div class="login-container1">

                    <div class="remember-me">

                        <div class="form-check">
                            <input type="checkbox" value="1" name="remember_me" id="remember-me" class="form-check-input">
                            <label for="remember-me" class="form-check-label">Remember me</label>
                        </div>
                        
                    </div>

                    <div class="forgot-password">

                        <a id="forgot-password" href="forgot-password.html">Forgot password?</a>

                    </div>

                </div>

                <div class="login-container2">

                    <div class="login-btn">
                        <button class="btn btn-primary" type="submit">Sign in</button>
                    </div>

                    <div class="new-user">
                    
                        <span>New user?</span>

                        <span>
                            <a id="new-user" href="register.html">Create an account</a>
                        </span>

                    </div>
                    
                </div>

            </div>

        </form>

    </div>

</div>
@endsection