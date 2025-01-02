@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">{{ __('Register') }}</span>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="input-field">
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="validate">
                                <label for="name">{{ __('Name') }}</label>
                                @error('name')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="input-field">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="validate">
                                <label for="email">{{ __('Email') }}</label>
                                @error('email')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="input-field">
                                <input id="password" type="password" name="password" required autocomplete="new-password" class="validate">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="input-field">
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="validate">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                @error('password_confirmation')
                                <span class="helper-text" data-error="{{ $message }}"></span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col s12">
                                    <a href="{{ route('login') }}" class="blue-text text-darken-2">{{ __('Already registered?') }}</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12">
                                    <button type="submit" class="btn waves-effect waves-light">{{ __('Register') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
