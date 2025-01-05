@extends('layouts.guest')

@section('content')
    <div class="card m-none">
        <div class="card-content">
            <div class="image-container">
                <img src="{{ asset('svg/logoipsum.svg') }}" alt="Icon">
            </div>

            <span class="card-title fs-28 fw-600 center-align">{{ __('Register') }}</span>

            <div class="row">
                <div class="col s12 right-align">
                    <a href="{{ route('login') }}" class="blue-text">{{ __('Already registered?') }}</a>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <!-- Name -->
                    <div class="col s12">
                        <input id="name" type="text" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="validate">
                        @error('name')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="col s12">
                        <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="username" class="validate">

                        @error('email')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="col s12">
                        <password-validator :show-header="false"></password-validator>
                        @error('password')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="col s12">
                        <input id="password_confirmation" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password" class="validate">
                        @error('password_confirmation')
                        <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 center-align">
                        <button type="submit" class="btn light-blue-bg">{{ __('Register') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
