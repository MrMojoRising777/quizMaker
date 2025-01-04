@extends('layouts.guest')

@section('content')
    <div class="card login-card m-none">
        <div class="card-content">
            <div class="image-container">
                <img src="{{ asset('svg/logoipsum.svg') }}" alt="Icon">
            </div>

            <span class="card-title fs-28 fw-600 center-align">{{ __('Login') }}</span>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4">
                    <div class="chip green">{{ session('status') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="input-field">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="validate">
                    <label for="email">{{ __('Email') }}</label>
                    @error('email')
                    <span class="helper-text" data-error="{{ $message }}"></span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-field">
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="validate">
                    <label for="password">{{ __('Password') }}</label>
                    @error('password')
                        <span class="helper-text" data-error="{{ $message }}"></span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="row">
                    <div class="col s12">
                        <label>
                            <input type="checkbox" name="remember" />
                            <span>{{ __('Remember me') }}</span>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="blue-text text-darken-2">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 center-align">
                        <button type="submit" class="btn light-green-bg">{{ __('Log in') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
