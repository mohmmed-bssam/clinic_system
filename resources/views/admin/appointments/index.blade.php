<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Appointments',
        'subtitle' => 'Review and update patient appointments.',
    ])<div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->department->name }}</td>
                            <td>{{ $appointment->appointment_at->format('M d, Y H:i') }}</td>
                            <td><span
                                    class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($appointment->status) }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.appointments.show', $appointment) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                    </tr>@empty<tr>
                            <td colspan="6" class="text-center py-5 text-muted">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $appointments->links() }}</div>
    </div></x-admin-layout>
