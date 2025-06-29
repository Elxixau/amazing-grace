<!DOCTYPE html>


<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title') |  {{ ('app.name') }}</title>


    @stack('styles')
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/material/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="{{ asset('assets/admin/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/blogs/blog-5/assets/css/blog-5.css">

    <link href="{{ asset('assets/admin/plugins/prism/prism.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}" />




    <!-- FAVICON -->
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />

    <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <script src="plugins/nprogress/nprogress.js"></script>
</head>


<body class="navbar-fixed sidebar-fixed" id="body">
    <script>
        NProgress.configure({
            showSpinner: false
        });
        NProgress.start();
    </script>



    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">


        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <!-- Aplication Brand -->
                <div class="app-brand">
                    <a href="">
                        <img src="{{ asset('images/LOGO. REV2.png') }}" alt="Mono" style="width: 30px;">
                        <span class="brand-name">Amazing Grace</span>
                    </a>
                </div>
            <ul class="nav sidebar-inner" id="sidebar-menu">

    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="sidenav-item-link" href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-chart-line"></i>
            <span class="nav-text">Home Dashboard</span>
        </a>
    </li>

    <li class="section-title">
        Utilities
    </li>

    <li class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
        <a class="sidenav-item-link" href="{{ route('admin.user.index') }}">
            <i class="mdi mdi-account-group"></i>
            <span class="nav-text">Users</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.ticket.*') ? 'active' : '' }}">
        <a class="sidenav-item-link" href="{{ route('admin.ticket.index') }}">
            <i class="mdi mdi-ticket"></i>
            <span class="nav-text">Ticket</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
        <a class="sidenav-item-link" href="{{route('admin.log.index')}}">
            <i class="mdi mdi-history"></i>
            <span class="nav-text">log Activity</span>
        </a>
    </li>

    <li class="section-title">
        Pages
    </li>

    <li class="{{ request()->routeIs('admin.post.*') ? 'active' : '' }}">
        <a class="sidenav-item-link" href="{{ route('admin.post.index') }}">
            <i class="mdi mdi-square-edit-outline"></i>
            <span class="nav-text">Customization</span>
        </a>
    </li>

</ul>



            </div>
        </aside>



        <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
        <div class="page-wrapper">

            <!-- Header -->
            <header class="main-header" id="header">
                <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                    <!-- Sidebar toggle button -->
                    <button id="sidebar-toggler" class="sidebar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                    </button>

                    <span class="page-title"></span>

                    <div class="navbar-right ">

                        <!-- search form -->
                        <div class="search-form">
                            <form action="index.html" method="get">
                                <div class="input-group input-group-sm" id="input-group-search">
                                    <input type="text" autocomplete="off" name="query" id="search-input"
                                        class="form-control" placeholder="Search..." />
                                    <div class="input-group-append">
                                        <button class="btn" type="button">/</button>
                                    </div>
                                </div>
                            </form>
                            <ul class="dropdown-menu dropdown-menu-search">

                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">Morbi leo risus</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">Dapibus ac facilisis in</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">Porta ac consectetur ac</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">Vestibulum at eros</a>
                                </li>

                            </ul>

                        </div>

                        <ul class="nav navbar-nav">

                            @php
                                use App\Models\RouteLog;
                                $Logs = RouteLog::with('user')
                                    ->latest('logged_at')
                                    ->take(5)
                                    ->get();
                            @endphp

                            <li class="custom-dropdown position-relative">
                                <button class="notify-toggler custom-dropdown-toggler">
                                    <i class="mdi mdi-bell-outline icon"></i>
                                    <span class="badge badge-xs rounded-circle">{{ $Logs->count() }}</span>
                                </button>
                                <div class="dropdown-notify">
                                    <header>
                                        <div class="nav nav-underline" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="all-tabs" data-toggle="tab"
                                                href="#all" role="tab" aria-controls="nav-home" aria-selected="true">All ({{ $Logs->count() }})</a>
                                        </div>
                                    </header>

                                    <div class="" data-simplebar style="height: 325px;">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tabs">
                                                @foreach($Logs as $log)
                                                    <div class="media media-sm {{ $loop->odd ? 'bg-light' : 'bg-warning-10' }} p-3">
                                                        <div class="media-sm-wrapper" style="width: 36px; height: 36px; overflow: hidden; border-radius: 50%;">
                                                            <img src="{{ asset($log->user?->profile_img ? 'storage/' . $log->user->profile_img : 'images/user/default.png') }}" style="width: 100%; height: 100%; object-fit: cover;" alt="User">
                                                        </div>
                                                        <div class="media-body">
                                                            <span class="title mb-0">{{ $log->user->name ?? 'Guest' }}</span>
                                                            <span class="discribe">{{ $log->summary }}</span>
                                                            <span class="time">
                                                                <time>{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</time>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <footer class="border-top dropdown-notify-footer">
                                        <div class="d-flex justify-content-between align-items-center py-2 px-4">
                                            <span>Terakhir diperbarui {{ now()->diffForHumans() }}</span>
                                            <a id="refress-button" href="javascript:" class="btn mdi mdi-cached btn-refress"></a>
                                        </div>
                                    </footer>
                                </div>
                            </li>

                            <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="{{ Auth::user()->profile_img 
                                            ? asset('storage/' . Auth::user()->profile_img) 
                                            : asset('images/default-profile.png') }}"
                                        class="user-image rounded-circle" alt="User Image" />
                                    <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    
                                    
                                    <li>
                                        <a class="dropdown-link-item" href="{{route('admin.profile.index')}}">
                                            <i class="mdi mdi-settings"></i>
                                            <span class="nav-text">Profile Setting</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-footer">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button><a class="dropdown-link-item"> <i
                                                class="mdi mdi-logout"></i> Log Out </a></button>
                                        </form>
                                        
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>


            </header>

            <!-- ====================================
        ——— CONTENT WRAPPER
        ===================================== -->
              <div class="content-wrapper">
            <div class="content"><!-- For Components documentaion -->
    
                
                @if(isset($breadcrumbItems))
                    @include('components.breadcrumb', ['items' => $breadcrumbItems])
                @endif




            <div class="row">
                <div class="col-xl-12">
                <!-- Basic Table-->
                @yield('content')
                </div>
            </div>
            </div>
        </div>
            

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        &copy; <span id="copy-year"></span> Copyright Amazing Grace Develop by  <a
                            class="text-primary" href="http://www.iamabdus.com/" target="_blank">Elxixau</a>.
                    </p>
                </div>
                <script>
                    var d = new Date();
                    var year = d.getFullYear();
                    document.getElementById("copy-year").innerHTML = year;
                </script>
            </footer>

        </div>
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="{{ asset('assets/admin/plugins/prism/prism.js') }}"></script>

    <script src="{{ asset('assets/admin/js/mono.js') }}"></script>
    <script src="{{ asset('assets/admin/js/chart.js') }}"></script>
    <script src="{{ asset('assets/admin/js/map.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>

    @stack('scripts')


    <script src="{{ asset('js/admin-layout.js') }}"></script>



</body>

</html>
