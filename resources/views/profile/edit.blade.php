@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-title center-align">{{ __('Profile') }}</div>

            <div class="row mb-0">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">{{ __('Profile Information') }}</div>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">{{ __('Update Password') }}</div>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title">{{ __('Delete User') }}</div>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
