<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method ?? false)
        @method($method)
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $doctor->name ?? '') }}"
                class="form-control" autofocus>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="slug" class="form-label">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $doctor->slug ?? '') }}"
                class="form-control">
            @error('slug')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="department_id" class="form-label">Department</label>
            <select id="department_id" name="department_id" class="form-select">
                <option value="">Select department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $doctor->department_id ?? '') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="specialization" class="form-label">Specialization</label>
            <input id="specialization" name="specialization" type="text"
                value="{{ old('specialization', $doctor->specialization ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $doctor->email ?? '') }}"
                class="form-control">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $doctor->phone ?? '') }}"
                class="form-control">
        </div>
        @if (!($method ?? false))
            <div class="col-md-6">
                <label for="password" class="form-label">Login password</label>
                <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control"
                    autocomplete="new-password">
            </div>
        @endif
        <div class="col-12">
            <label for="bio" class="form-label">Bio</label>
            <textarea id="bio" name="bio" rows="5" class="form-control">{{ old('bio', $doctor->bio ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Image {{ $method ?? false ? '(optional)' : '' }}</label>
            @if (isset($doctor) && $doctor->media)
                <div class="mb-3"><img src="{{ asset($doctor->media->path) }}" alt="{{ $doctor->name }}"
                        class="rounded" style="width: 120px; height: 120px; object-fit: cover;"></div>
            @endif
            <input id="image" name="image" type="file" accept="image/*" class="form-control">
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check">
                <input id="doctor-status" name="status" type="checkbox" value="1" class="form-check-input"
                    @checked(old('status', $doctor->status ?? true))>
                <label for="doctor-status" class="form-check-label">Active</label>
            </div>
        </div>
    </div>

    <div class="border-top mt-4 pt-4">
        <h5 class="mb-3">Weekly working hours</h5>
        @php
            $days = [
                0 => 'Sunday',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
            ];
            $savedSchedule = isset($doctor) ? $doctor->schedules->keyBy('day_of_week') : collect();
        @endphp
        <div class="row g-3">
            @foreach ($days as $day => $label)
                @php $hours = $savedSchedule->get($day); @endphp
                <div class="col-md-6 col-xl-4">
                    <div class="border rounded p-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="schedule[{{ $day }}][enabled]" value="1"
                                id="schedule-{{ $day }}" @checked(old("schedule.$day.enabled", $hours !== null))>
                            <label class="form-check-label"
                                for="schedule-{{ $day }}">{{ $label }}</label>
                        </div>
                        <div class="d-flex gap-2">
                            <input class="form-control" type="time"
                                name="schedule[{{ $day }}][starts_at]"
                                value="{{ old("schedule.$day.starts_at", $hours?->starts_at ?? '15:00') }}">
                            <input class="form-control" type="time" name="schedule[{{ $day }}][ends_at]"
                                value="{{ old("schedule.$day.ends_at", $hours?->ends_at ?? '18:00') }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $cancel }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save doctor</button>
    </div>
</form>
