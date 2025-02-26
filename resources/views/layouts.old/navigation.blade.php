<ul id="dropdown1" class="dropdown-content">
    <li>
        <a href="{{ route('profile.edit') }}" class="black-text">
            {{ __('Profile') }}
        </a>
    </li>
    <li class="divider"></li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-flat black-text">{{ __('Log Out') }}</button>
        </form>
    </li>
</ul>
<nav class="nav-wrapper blue-bg">
    <a href="{{ route('dashboard') }}" class="brand-logo ml-5">
        LOGO
    </a>
    <div class="container">
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="{{ route('quizzes.index') }}" class="black-text {{ request()->routeIs('quiz.index') ? 'active' : '' }}">
                    {{ __("Quizzes") }}
                </a>
            </li>
            <li>
                <a class="dropdown-trigger" href="#!" data-target="dropdown1">
                    {{ auth()->user()->name }}<i class="material-icons right">arrow_drop_down</i>
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
