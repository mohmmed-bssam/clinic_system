<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New Appointment',
        'subtitle' => 'Schedule a patient during the doctor working hours.',
    ])

    <div class="card">
        <div class="p-4">
            <form method="POST" action="{{ route('admin.appointments.store') }}" class="row g-4">
                @csrf
                <div class="col-md-6">
                    <label for="patient_id" class="form-label">Existing patient</label>
                    <select id="patient_id" name="patient_id" class="form-select">
                        <option value="">Select existing patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>{{ $patient->name }}
                                ({{ $patient->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <div class="text-muted text-center">Or create a new patient below</div>
                </div>
                <div class="col-md-4">
                    <label for="new_patient_name" class="form-label">New patient name</label>
                    <input id="new_patient_name" name="new_patient_name" type="text"
                        value="{{ old('new_patient_name') }}" class="form-control">
                    @error('new_patient_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="new_patient_email" class="form-label">New patient email</label>
                    <input id="new_patient_email" name="new_patient_email" type="email"
                        value="{{ old('new_patient_email') }}" class="form-control">
                    @error('new_patient_email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="new_patient_password" class="form-label">Patient password</label>
                    <input id="new_patient_password" name="new_patient_password" type="password" class="form-control">
                    @error('new_patient_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="new_patient_password_confirmation" class="form-label">Confirm password</label>
                    <input id="new_patient_password_confirmation" name="new_patient_password_confirmation"
                        type="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="doctor_id" class="form-label">Doctor</label>
                    <select id="doctor_id" name="doctor_id" class="form-select" required>
                        <option value="">Select doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                {{ $doctor->name }}{{ $doctor->department ? ' - ' . $doctor->department->name : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="appointment_at" class="form-label">Appointment date and time</label>
                    <input id="appointment_at" name="appointment_at" type="datetime-local"
                        value="{{ old('appointment_at') }}" class="form-control" required>
                    @error('appointment_at')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save
                        appointment</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
