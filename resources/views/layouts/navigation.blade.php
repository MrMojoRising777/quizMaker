<nav class="nav-wrapper bg-blue">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            LOGO
        </a>

        <ul class="right hide-on-med-and-down">
            <li>
                <a href="{{ route('quiz.index') }}" class="text-black {{ request()->routeIs('quiz.index') ? 'active' : '' }}">
                    Quizzen
                </a>
            </li>
        </ul>

        <!-- Hamburger Menu (for mobile) -->
        <a href="#" data-target="mobile-nav" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
    </div>

    <ul class="sidenav" id="mobile-nav">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('Dashboard') }}</a></li>
        <li><a href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="waves-effect waves-light btn-flat">{{ __('Log Out') }}</button>
            </form>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(elems);
    });
</script>
