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

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $cancel }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save doctor</button>
    </div>
</form>
