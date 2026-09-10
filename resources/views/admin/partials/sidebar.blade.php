<div class="sidebar-wrapper" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <i class="bi bi-heart-pulse-fill"></i>
        <span>Clinic Admin</span>
    </a>

    <div class="flex-grow-1 overflow-y-auto">
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">Overview</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        title="Dashboard">
                        <i class="bi bi-grid-fill"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.appointments.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"
                        title="Appointments">
                        <i class="bi bi-calendar2-check"></i><span>Appointments</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.messages.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
                        title="Messages">
                        <i class="bi bi-envelope"></i><span>Messages</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">Clinic Management</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item"><a href="{{ route('admin.departments.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
                        title="Departments"><i class="bi bi-diagram-3"></i><span>Departments</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.services.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                        title="Services"><i class="bi bi-heart-pulse"></i><span>Services</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.doctors.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
                        title="Doctors"><i class="bi bi-person-badge"></i><span>Doctors</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.testimonials.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"
                        title="Testimonials"><i class="bi bi-chat-quote"></i><span>Testimonials</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.faqs.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                        title="FAQs"><i class="bi bi-question-circle"></i><span>FAQs</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.settings.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                        title="Settings"><i class="bi bi-gear"></i><span>Settings</span></a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-profile-img d-flex align-items-center justify-content-center bg-lime-accent text-main">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-profile-email">{{ auth()->user()->email }}</div>
        </div>
    </div>
</div>
