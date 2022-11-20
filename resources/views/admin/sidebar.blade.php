<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{config('app.url')}}" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->image}}" class="img-circle elevation-2" style="height: 35px; width: 35px;" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('profile')}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($navItems as $key => $val)
                @if($key != "Static Pages")
                <li class="nav-item">
                    <a href="{{route($val['route'])}}" class="nav-link {{$val['route'] == Route::currentRouteName() ? "active" : ""}}">
                        <i class="nav-icon fas {{$val['iconClass']}}"></i>
                        <p>{{$key}}</p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is($val['active-route']) ? 'active' : '' }}">
                        <i class="nav-icon {{$val['iconClass']}}"></i>
                        <p>
                            {{$key}}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        @foreach ($val['pages'] as $subKey => $subValue )
                        <li class="nav-item">
                            @php
                            $page = Route::current()->parameters['slug']?? "";
                            @endphp
                            <a href="{{route($subValue['route'],$subValue['param'])}}" class="nav-link  {{$subValue['param']['slug'] == $page ? "active" : ""}}">
                                <i class="far fa-circle  {{$subValue['iconClass']}}"></i>
                                <p>{{$subKey}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endif
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>