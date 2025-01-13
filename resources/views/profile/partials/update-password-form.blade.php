<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="input-field">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <span class="red-text text-darken-2">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <div class="input-field">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <span class="red-text text-darken-2">{{ $errors->updatePassword->first('password') }}</span>
            @endif
        </div>

        <div class="input-field">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <span class="red-text text-darken-2">{{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="input-field">
            <button type="submit" class="btn waves-effect waves-light">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="green-text text-darken-2" id="password-updated-message">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
