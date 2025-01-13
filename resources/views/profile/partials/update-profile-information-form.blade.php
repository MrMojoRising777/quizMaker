<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col s12">
                <file-upload
                    :avatar-path="'{{ optional(auth()->user())->avatar
                    ? '/storage/' . auth()->user()->avatar
                    : ''
                    }}'"
                ></file-upload>
            </div>
        </div>

        <div class="row">
            <div class="col s6">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" class="validate" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <span class="red-text text-darken-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col s6">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" class="validate" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <span class="red-text text-darken-2">{{ $message }}</span>
                @enderror
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="card-panel yellow lighten-4">
                        <p>
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn-flat blue-text">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="green-text text-darken-2">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <button type="submit" class="btn waves-effect waves-light">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</section>
