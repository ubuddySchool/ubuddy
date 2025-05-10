@extends('layouts.app')

@section('content')
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <img class="img-fluid" src="{{ asset('assets/img/login.png') }}" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>Welcome to ubuddy</h1>
                        <!-- <p class="account-subtitle">Need an account? <a href="{{ route('register') }}">Sign Up</a></p> -->
                        <h2>Sign in</h2>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username <span class="login-danger">*</span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"  autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password <span class="login-danger">*</span></label>
                                <input id="password" type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="profile-views feather-eye toggle-password"></span>
                            </div>
                            <!-- <div class="forgotpass">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div> -->
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </form>

                        

                        <div class="copyright social-login">
                                <p> © Copyright - UBUDDY 2025
                                    <br> All rights reserved.
                                </p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
