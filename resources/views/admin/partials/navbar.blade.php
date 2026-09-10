<header class="navbar-custom">
    <div class="navbar-left">
        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
            id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
            <i class="bi bi-chevron-bar-left"></i>
        </button>
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
            <i class="bi bi-list"></i>
        </button>
        <div class="dropdown ms-2">
            <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-plus-lg"></i><span>Create</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-quick-action">
                <li class="dropdown-header">Quick Actions</li>
                <li><a class="dropdown-item" href="{{ route('admin.departments.create') }}"><i
                            class="bi bi-diagram-3"></i> New Department</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.services.create') }}"><i
                            class="bi bi-heart-pulse"></i> New Service</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.doctors.create') }}"><i
                            class="bi bi-person-plus"></i> New Doctor</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.faqs.create') }}"><i
                            class="bi bi-question-circle"></i> New FAQ</a></li>
            </ul>
        </div>
    </div>

    <div class="navbar-search-wrapper">
        <input type="text" class="navbar-search-input" placeholder="Search clinic records..." id="main-search">
        <button class="navbar-search-btn" aria-label="Search"><i class="bi bi-search"></i></button>
    </div>

    <div class="navbar-actions">
        <div class="dropdown ms-2">
            <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span
                    class="navbar-profile-img d-flex align-items-center justify-content-center bg-lime-accent text-main"><i
                        class="bi bi-person-fill"></i></span>
                <span class="navbar-profile-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                <i class="bi bi-chevron-down navbar-profile-caret"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile">
                <li class="dropdown-header">{{ auth()->user()->email }}</li>
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> My
                        Account</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i>
                            Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
