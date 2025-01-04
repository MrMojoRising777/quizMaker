@extends('layouts.guest')

@section('content')
    <div class="card login-card">
        <div class="card-content">
            <div class="image-container">
                <img src="{{ asset('svg/logoipsum.svg') }}" alt="Icon">
            </div>

            <div class="card-title fs-28 fw-600 center-align">Reset Password</div>

            <div class="">
                {{ __("Enter your email address below and we'll send you a link to reset your password.") }}
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="card-panel green lighten-4 green-text text-darken-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="input-field">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="validate">
                    @error('email')
                        <span class="red-text text-darken-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="left-align mt-4">
                    <button type="submit" class="btn light-green-bg">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
