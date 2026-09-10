<x-admin-layout>
    <div class="page-header">
        <div>
            <h1 class="page-title">Clinic Dashboard</h1>
            <p class="page-subtitle">Manage your clinic with care and precision.</p>
        </div>
        <a href="{{ route('admin.appointments.index') }}" class="btn-quick-action">
            <i class="bi bi-calendar-plus"></i><span>View Appointments</span>
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card alert-green-card">
                <div class="position-relative z-index-2">
                    <span class="alert-green-badge">Today</span>
                    <div class="alert-green-date">Clinic overview</div>
                    <div class="alert-green-text">Keep every patient journey organized.</div>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="alert-green-link z-index-2"><span>Open
                        schedule</span><i class="bi bi-arrow-right"></i></a>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Patients</span><i class="bi bi-people text-main"></i>
                </div>
                <div class="stat-value">{{ $patientsCount }}</div>
                <div class="trend-badge trend-up"><i class="bi bi-person-check"></i><span>Registered patients</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Doctors</span><i
                        class="bi bi-person-badge text-main"></i></div>
                <div class="stat-value">{{ $doctorsCount }}</div>
                <div class="trend-badge trend-up"><i class="bi bi-heart-pulse"></i><span>Active doctors</span></div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Pending Appointments</span><i
                        class="bi bi-calendar-event text-main"></i></div>
                <div class="stat-value">{{ $pendingAppointmentsCount }}</div>
                <div class="trend-badge trend-down"><i class="bi bi-clock"></i><span>Need attention</span></div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header">
                    <h2 class="card-title">Clinic Resources</h2>
                    <span class="text-muted-green">{{ $appointmentsCount }} total appointments</span>
                </div>
                <div class="progress-container">
                    <div class="progress-label-row"><span class="progress-label">Departments</span><span
                            class="progress-value">{{ $departmentsCount }}</span></div>
                    <div class="progress" role="progressbar">
                        <div class="progress-bar bg-lime-accent" style="width: {{ min($departmentsCount * 10, 100) }}%">
                        </div>
                    </div>
                </div>
                <div class="progress-container">
                    <div class="progress-label-row"><span class="progress-label">Active doctors</span><span
                            class="progress-value">{{ $doctorsCount }}</span></div>
                    <div class="progress" role="progressbar">
                        <div class="progress-bar bg-lime-accent" style="width: {{ min($doctorsCount * 10, 100) }}%">
                        </div>
                    </div>
                </div>
                <div class="progress-container">
                    <div class="progress-label-row"><span class="progress-label">Pending appointments</span><span
                            class="progress-value">{{ $pendingAppointmentsCount }}</span></div>
                    <div class="progress" role="progressbar">
                        <div class="progress-bar bg-brand-orange"
                            style="width: {{ min($pendingAppointmentsCount * 10, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="promo-banner-card h-100">
                <i class="bi bi-heart-pulse-fill text-lime display-5"></i>
                <h3 class="promo-title">A healthier clinic starts with a clear overview.</h3>
                <p class="promo-desc">Manage departments, doctors, services, and appointments from one place.</p>
                <a href="{{ route('admin.departments.index') }}" class="btn-promo">Manage clinic</a>
            </div>
        </div>
    </div>
</x-admin-layout>
