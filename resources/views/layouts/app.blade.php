<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <link href="{{ URL::asset('/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">

        @yield('css')
    </head>
    <body>
        <div id="main-wrapper">
            <div class="nav-header">
                <a href="index.html" class="brand-logo">
                    <img class="logo-abbr" src="./images/logo.png" alt="">
                    <img class="logo-compact" src="./images/logo-text.png" alt="">
                    <img class="brand-title" src="./images/logo-text.png" alt="">
                </a>

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="line"></span><span class="line"></span><span class="line"></span>
                    </div>
                </div>
            </div>

            <div class="header">
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="collapse navbar-collapse justify-content-between">
                            <div class="header-left">
                                <div class="search_bar dropdown">
                                    <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                        <i class="mdi mdi-magnify"></i>
                                    </span>
                                    <div class="dropdown-menu p-0 m-0">
                                        <form>
                                            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <ul class="navbar-nav header-right">
                                <li class="nav-item dropdown header-profile">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                        <i class="mdi mdi-account"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="/user/profile" class="dropdown-item">
                                            <i class="icon-user"></i>
                                            <span class="ml-2">Profile </span>
                                        </a>
                                        <a href="./email-inbox.html" class="dropdown-item">
                                            <i class="icon-envelope-open"></i>
                                            <span class="ml-2">Inbox </span>
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();" class="dropdown-item">
                                                <i class="icon-key"></i>
                                                <span class="ml-2">Logout </span>
                                            </a>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="quixnav">
                <div class="quixnav-scroll">
                    <ul class="metismenu" id="menu">
                        <li class="nav-label first">Main Menu</li>
                        <li><a href="./index.html">Dashboard 1</a></li>
                        <li class="nav-label">Stores</li>
                        @if(auth()->user()->role == 'admin')
                            <li><a href="/users">Users</a></li>
                        @endif
                        <li><a href="/stores">stores</a></li>
                        <li><a href="/store/categories">stores categories</a></li>
                        <li><a href="/product">product</a></li>
                        <li><a href="/product/categories">restaurant add on</a></li>
                        <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <span class="nav-text">oder</span></a>
                            <ul aria-expanded="false">
                                <li><a href="/oder/new">new</a></li>
                                <li><a href="/oder/on-going">on going</a></li>
                                <li><a href="/oder/past">past</a></li>
                            </ul>
                        </li>
                        <li><a href="/eraning">eraning</a></li>
                        <li><a href="/transaction">transaction</a></li>
                    </ul>
                </div>
            </div>

            @yield('content')

            <div class="footer">
                <div class="copyright">
                    <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">rs-patel</a> 2022</p>
                </div>
            </div>
        </div>

    <script src="{{URL::asset('/vendor/global/global.min.js')}}"></script>
    <script src="{{URL::asset('/js/quixnav-init.js')}}"></script>
    <script src="{{URL::asset('/js/custom.min.js')}}"></script>
    <!-- Datatable -->
    <script src="{{URL::asset('/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{URL::asset('/vendor/highlightjs/highlight.pack.min.js')}}"></script>

    @yield('js')
    </body>
</html>
