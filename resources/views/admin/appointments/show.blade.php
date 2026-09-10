<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Appointment #' . $appointment->id,
        'subtitle' => 'Appointment details and status.',
    ])<div class="card p-4">
        <dl class="row">
            <dt class="col-sm-3">Patient</dt>
            <dd class="col-sm-9">{{ $appointment->patient->name }} ({{ $appointment->patient->email }})</dd>
            <dt class="col-sm-3">Doctor</dt>
            <dd class="col-sm-9">{{ $appointment->doctor->name }}</dd>
            <dt class="col-sm-3">Date</dt>
            <dd class="col-sm-9">{{ $appointment->appointment_at->format('M d, Y H:i') }}</dd>
        </dl>
        <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}" class="row g-3">@csrf
            @method('PUT')<div class="col-md-6"><label class="form-label">Status</label><select name="status"
                    class="form-select">
                    @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select></div>
            <div class="col-12"><label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="4">{{ $appointment->notes }}</textarea>
            </div>
            <div class="col-12"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Update
                    appointment</button></div>
        </form>
    </div></x-admin-layout>
