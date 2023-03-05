<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('admin.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{getSettings('logo_image')}}" alt="{{config('app.name')}}" height="60" width="60">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item pr-md-1">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item pr-md-1 dropdown">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#admin_logout" class="nav-link"><i class="fa fa-power-off text-danger mr-2"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sidebar_button" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fa-solid fa-cog fa-spin" style="--fa-animation-duration: 5s;"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="modal fade" id="admin_logout">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Logout</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{route('admin.logout')}}" type="button" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('admin.sidebar')

        <div class="content-wrapper">
            <div class="px-md-3 px-sm-2 pt-md-4 pt-sm-2">
                {{ $slot }}
            </div>
        </div>
        <!-- sidebar-controll -->
        @include('admin.sidebar-controll')
        <div id="sidebar-overlay"></div>
    </div>
    @include('admin.footer')
</body>

</html>