<x-admin-layout>
    <div class="page-header">
        <div>
            <h1 class="page-title">Good morning, Dr. {{ $doctor->name }}</h1>
            <p class="page-subtitle">Today’s patient queue · {{ now()->format('l, M d, Y') }}</p>
        </div>
        <span class="badge bg-lime-accent text-main px-3 py-2">{{ $appointments->count() }} patients today</span>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title"><i class="bi bi-person-video3 me-2 text-main"></i>Next patient</h2>
            @if ($nextAppointment)
                <span class="badge bg-warning text-dark">{{ ucfirst($nextAppointment->status) }}</span>
            @endif
        </div>
        @if ($nextAppointment)
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <div class="small text-muted">Patient number 1 in the waiting queue</div>
                    <h3 class="mb-1">{{ $nextAppointment->patient->name }}</h3>
                    <div class="text-muted"><i
                            class="bi bi-clock me-1"></i>{{ $nextAppointment->appointment_at->format('h:i A') }}</div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="small text-muted mb-1">Time remaining</div>
                    <div class="display-6 fw-bold text-main" id="next-appointment-countdown"
                        data-appointment-time="{{ $nextAppointment->appointment_at->toIso8601String() }}">--:--:--</div>
                </div>
            </div>
        @else
            <div class="py-3 text-muted"><i class="bi bi-check2-circle me-2"></i>No upcoming patient is waiting today.
            </div>
        @endif
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Total today</span><i
                        class="bi bi-calendar2-check text-main"></i></div>
                <div class="stat-value">{{ $appointments->count() }}</div>
                <div class="trend-badge trend-up"><i class="bi bi-people"></i><span>Scheduled patients</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Waiting</span><i
                        class="bi bi-hourglass-split text-main"></i></div>
                <div class="stat-value">{{ $waitingCount }}</div>
                <div class="trend-badge trend-down"><i class="bi bi-clock"></i><span>Pending or confirmed</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat">
                <div class="card-header"><span class="stat-label">Completed</span><i
                        class="bi bi-check2-circle text-main"></i></div>
                <div class="stat-value">{{ $completedCount }}</div>
                <div class="trend-badge trend-up"><i class="bi bi-person-check"></i><span>Visits completed</span></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Patient queue</h2><span class="text-muted-green">Sorted by appointment time</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Queue</th>
                        <th>Patient</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $index => $appointment)
                        <tr>
                            <td><span class="badge bg-light text-dark">#{{ $index + 1 }}</span></td>
                            <td><strong>{{ $appointment->patient->name }}</strong>
                                <div class="small text-muted">{{ $appointment->patient->email }}</div>
                            </td>
                            <td>{{ $appointment->appointment_at->format('h:i A') }}</td>
                            <td><span
                                    class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'confirmed' ? 'primary' : 'warning') }}">{{ ucfirst($appointment->status) }}</span>
                            </td>
                            <td class="text-end"><span class="text-muted small">In queue</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No patients are scheduled for today.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($nextAppointment)
        @push('scripts')
            <script>
                (() => {
                    const countdown = document.getElementById('next-appointment-countdown');
                    const appointmentTime = new Date(countdown.dataset.appointmentTime).getTime();

                    const updateCountdown = () => {
                        const remaining = Math.max(0, appointmentTime - Date.now());
                        const totalSeconds = Math.floor(remaining / 1000);
                        const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                        const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                        const seconds = String(totalSeconds % 60).padStart(2, '0');

                        countdown.textContent = `${hours}:${minutes}:${seconds}`;

                        if (remaining === 0) {
                            countdown.classList.add('text-danger');
                        }
                    };

                    updateCountdown();
                    window.setInterval(updateCountdown, 1000);
                })();
            </script>
        @endpush
    @endif
</x-admin-layout>
