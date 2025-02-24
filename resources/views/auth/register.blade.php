@extends('layouts.app')

@section('content')

<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <img class="img-fluid" src="assets/img/login.png" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>{{ __('Sign Up') }}</h1>
                        <p class="account-subtitle">{{ __('Enter details to create your account') }}</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div class="form-group">
                                <label>{{ __('Full Name') }} <span class="login-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                <span class="profile-views"><i class="fas fa-user-circle"></i></span>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Contact No. Field -->
                            <div class="form-group">
                                <label>{{ __('Contact Number') }} <span class="login-danger">*</span></label>
                                <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}">
                                <span class="profile-views"><i class="fas fa-phone"></i></span>

                                @error('contact_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="form-group">
                                <label>{{ __('Address') }} <span class="login-danger">*</span></label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                                <span class="profile-views"><i class="fas fa-home"></i></span>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- City Field -->
                            <div class="form-group">
                                <label>{{ __('City') }} <span class="login-danger">*</span></label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
                                <span class="profile-views"><i class="fas fa-city"></i></span>

                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Pincode Field -->
                            <div class="form-group">
                                <label>{{ __('Pincode') }} <span class="login-danger">*</span></label>
                                <input id="pincode" type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="{{ old('pincode') }}">
                                <span class="profile-views"><i class="fas fa-map-pin"></i></span>

                                @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Username Field -->
                            <div class="form-group">
                                <label>{{ __('Username') }} <span class="login-danger">*</span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
                                <span class="profile-views"><i class="fas fa-user-circle"></i></span>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Type Field -->
                            <div class="form-group">
                                <label>{{ __('User Type') }} <span class="login-danger">*</span></label>
                                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type">
                                    <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                                </select>

                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label>{{ __('Email') }} <span class="login-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
                                <span class="profile-views"><i class="fas fa-envelope"></i></span>


                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- Password Field -->
                            <div class="form-group">
                                <label>{{ __('Password') }} <span class="login-danger">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                <span class="profile-views feather-eye toggle-password"></span>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group">
                                <label>{{ __('Confirm Password') }} <span class="login-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                <span class="profile-views feather-eye reg-toggle-password"></span>
                                
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Already Registered? Link -->
                            <div class="dont-have">{{ __('Already Registered?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a></div>

                            <!-- Register Button -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>

                        <div class="login-or">
                            <span class="or-line"></span>
                            <span class="span-or">or</span>
                        </div>

                        <div class="social-login">
                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection