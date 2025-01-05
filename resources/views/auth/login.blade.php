@extends('layouts.guest')

@section('content')
    <div class="card m-none">
        <div class="card-content">
            <div class="image-container">
                <img src="{{ asset('svg/logoipsum.svg') }}" alt="Icon">
            </div>

            <span class="card-title fs-28 fw-600 center-align">{{ __('Login') }}</span>

            <div class="row">
                <div class="col s12 right-align">
                    <a href="{{ route('register') }}" class="blue-text">{{ __('No account?') }}</a>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4">
                    <div class="chip green">{{ session('status') }}</div>
                </div>
            @endif

            @foreach (['email', 'password'] as $field)
                @error($field)
                    <span class="helper-text red-text">{{ $message }}</span>
                @enderror
            @endforeach

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row">
                    <!-- Email Address -->
                    <div class="col s12">
                        <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="validate">
                    </div>

                    <div class="col s12">
                        <password-validator :show-feedback="false"></password-validator>
{{--                        <input id="password" type="password" placeholder="Password" name="password" required autocomplete="current-password" class="validate">--}}
                    </div>
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
