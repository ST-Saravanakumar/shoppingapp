<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('adminDashboard') }}" class="brand-link">
        <img src="{{ $site_logo }}" alt="SiteLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <!-- Sidebar -->
    <div class="sidebar mt-5">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->
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
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item {{ url()->current() == route('adminDashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('adminDashboard') }}" class="nav-link {{ url()->current() == route('adminDashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ url()->current() == route('admin.categories.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ url()->current() == route('admin.categories.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Manage Categories</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ url()->current() == route('admin.products.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ url()->current() == route('admin.products.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-product-hunt"></i>
                        <p>Manage Products</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ url()->current() == route('admin.users.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ url()->current() == route('admin.users.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Manage Users</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ url()->current() == route('admin.orders.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ url()->current() == route('admin.orders.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Manage Orders</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ url()->current() == route('admin.settings.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ url()->current() == route('admin.settings.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Site Settings</span>
                        </p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>