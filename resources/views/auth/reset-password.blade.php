@extends('layouts.guest')

@section('content')
    <div class="card">
        <div class="card-content">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <div class="image-container">
                    <img src="{{ asset('svg/logoipsum.svg') }}" alt="Icon">
                </div>

                <div class="card-title fs-28 fw-600 center-align">New Password</div>

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="input-field">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <span class="red-text">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <!-- Password -->
                <div class="input-field">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                    @if ($errors->has('password'))
                        <span class="red-text">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="input-field">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <span class="red-text">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div class="right-align">
                    <button class="btn waves-effect waves-light" type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
