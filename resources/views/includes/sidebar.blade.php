<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">E-SEURAMOE ADMIN</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">MASTER DATA</li>
            
            <li class="{{ (request()->is('admin-management*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.index') }}">
                    <i class="fas fa-cogs"></i> <span>Admin Management</span>
                </a>
            </li>


            <li class="{{ (request()->is('user-management*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-user-shield"></i> <span>User Management</span>
                </a>
            </li>

            <li class="{{ (request()->is('model-management*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('model.index') }}">
                <i class="fas fa-sitemap"></i><span>Model Management</span>
                </a>
            </li>

            <li class="{{ (request()->is('result-management*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('result.index') }}">
                    <i class="fas fa-chart-line"></i><span>Result Management</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
