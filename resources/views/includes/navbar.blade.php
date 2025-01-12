<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline me-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="nav-link dropdown-toggle nav-link-lg nav-link-user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ $dataUser['name'] }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <form action="{{ route('auth.logout') }}" method="POST" class="dropdown-item">
                @csrf
                <button type="submit" class="btn btn-link text-danger p-0">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </li>
</ul>
</nav>