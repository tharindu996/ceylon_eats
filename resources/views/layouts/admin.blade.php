<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'CeylonEat Admin')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin_assets/imgs/theme/favicon.svg') }}" />

    <!-- Template CSS -->
    <script src="{{ asset('admin_assets/js/vendors/color-modes.js') }}"></script>
    <link href="{{ asset('admin_assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('dashboard') }}" class="brand-wrap">
                <img src="{{ asset('admin_assets/imgs/theme/logo.svg') }}" class="logo" alt="CeylonEat Dashboard" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i
                        class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('dashboard') }}">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.users.index') }}">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">User Management</span>
                    </a>
                </li>
            </ul>
            <hr />
            <ul class="menu-aside">
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Products</span>
                    </a>
                    <div class="submenu">
                        <a href="#">Product List</a>
                        <a href="#">Categories</a>
                    </div>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.bookings.index') }}">
                        <i class="icon material-icons md-event_note"></i>
                        <span class="text">Bookings</span>
                    </a>
                </li>
                <li class="menu-item has-submenu {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-store"></i>
                        <span class="text">Vendors</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('admin.vendors.index') }}"
                            class="{{ request()->routeIs('admin.vendors.index') ? 'active' : '' }}">Vendor List</a>
                    </div>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.commissions.index') }}">
                        <i class="icon material-icons md-monetization_on"></i>
                        <span class="text">Commissions</span>
                    </a>
                </li>
            </ul>
            <hr />
            <ul class="menu-aside">
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-settings"></i>
                        <span class="text">Settings</span>
                    </a>
                    <div class="submenu">
                        <a href="#">Setting sample 1</a>
                    </div>
                </li>
            </ul>
            <br />
            <br />
        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input list="search_terms" type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button"><i
                                class="material-icons md-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                        class="material-icons md-apps"></i></button>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn-icon" href="#">
                            <i class="material-icons md-notifications animation-shake"></i>
                            <span class="badge rounded-pill">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i
                                class="material-icons md-nights_stay"></i> </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i
                                class="material-icons md-cast"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                            aria-expanded="false">
                            <img class="img-xs rounded-circle"
                                src="{{ asset('admin_assets/imgs/people/avatar-2.png') }}" alt="User" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href="#"><i
                                    class="material-icons md-perm_identity"></i>Edit Profile</a>
                            <a class="dropdown-item" href="#"><i class="material-icons md-settings"></i>Account
                                Settings</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="material-icons md-exit_to_app"></i>{{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <section class="content-main">
            @yield('content')
        </section>

        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    &copy; CeylonEat .
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">All rights reserved</div>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('admin_assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin_assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/vendors/chart.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('admin_assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>
