<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                {{-- @include('adminlte::partials.navbar.menu-item-dropdown-user-menu') --}}
            @else
                {{-- @include('adminlte::partials.navbar.menu-item-logout-link') --}}
            @endif
        @endif

        {{-- Custom User menu --}}
        @if(!Auth::user())
        <li class="nav-item usermenu">
            <a class="loginform btn btn-outline-success">
                <i class="fa fa-user">&nbspBejelentkezés</i>
            </a>
        </li>
        @else
        <li class="nav-item usermenu">
        <div class="dropdown">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user">&nbsp{{Auth::user()->name}}</i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item text-danger logout">Kijelentkezés</a>
            </div>
          </div>
        </li>
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
