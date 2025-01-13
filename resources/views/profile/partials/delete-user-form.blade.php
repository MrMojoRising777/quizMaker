<section>
    <!-- Delete Account Button -->
    <button
        class="btn red lighten-1 waves-effect waves-light modal-trigger"
        data-target="confirm-user-deletion-modal">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div id="confirm-user-deletion-modal" class="modal">
        <div class="modal-content">
            <h4>{{ __('Are you sure you want to delete your account?') }}</h4>
            <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <!-- Password Input -->
                <div class="input-field">
                    <label for="password">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="{{ __('Password') }}"
                        required
                    >
                    @if ($errors->userDeletion->has('password'))
                        <span class="red-text text-darken-2">{{ $errors->userDeletion->first('password') }}</span>
                    @endif
                </div>

                <!-- Modal Footer Actions -->
                <div class="modal-footer">
                    <button type="button" class="modal-close btn grey lighten-1 waves-effect waves-light">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn red lighten-1 waves-effect waves-light">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
