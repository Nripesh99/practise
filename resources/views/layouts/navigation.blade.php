<style>
    /* Custom CSS for Navigation Menu */
.navbar-brand {
    font-weight: bold;
}

.nav-link {
    padding: 0.5rem 1rem;
}

.dropdown-menu {
    min-width: 10rem;
}

.dropdown-menu a {
    color: #212529;
}

.dropdown-menu a:hover {
    background-color: #f8f9fa;
}

</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('path/to/your/logo.png') }}" alt="Logo" height="30">
        </a>

        <!-- Hamburger Button (visible on small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <!-- Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Manage User
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('users.index')}}">See Users</a></li>
                        <li><a class="dropdown-item" href="{{route('users.create')}}"> Add Users</a></li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Manage Sale
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('sales.index')}}">See Sale</a></li>
                        <li><a class="dropdown-item" href="{{route('sales.create')}}"> Add Sales</a></li>
                        <li><a class="dropdown-item" href="{{route('sales.all')}}"> All Sales</a></li>



                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">{{ __('Log Out') }}</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
