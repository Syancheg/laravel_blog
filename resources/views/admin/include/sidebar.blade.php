<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.main') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        @if(isset($data['left_menu']))
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @foreach($data['left_menu'] as $item)
                        @if($item['children'])
                            <li class="nav-item {{ Request::is('admin/' . $item['pathPrefix'] . '*') ? 'menu-is-opening menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa {{ $item['icon'] }}"></i>
                                    <p>
                                        {{ $item['title'] }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($item['children'] as $children)
                                        <li class="nav-item">
                                            <a href="{{ route($children['routeName']) }}"
                                               class="nav-link {{ Request::is('admin/' . $item['pathPrefix'] . '/' . $children['pathPrefix'] . '*') ? 'active' : '' }}"
                                            >
                                                <i class="nav-icon fa {{ $children['icon'] }}"></i>
                                                <p>{{ $children['title'] }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route($item['routeName']) }}"
                                   class="nav-link {{ Request::is('admin/' . $children['pathPrefix'] . '*') ? 'active' : '' }}"
                                >
                                    <i class="fa {{ $item['icon'] }} nav-icon"></i>
                                    <p>{{ $item['title'] }}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endif
    </div>
    <!-- /.sidebar -->
</aside>
