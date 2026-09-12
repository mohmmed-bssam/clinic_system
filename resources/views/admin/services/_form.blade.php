<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method ?? false)
        @method($method)
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $service->name ?? '') }}"
                class="form-control" autofocus>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="slug" class="form-label">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $service->slug ?? '') }}"
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
                    <option value="{{ $department->id }}" @selected(old('department_id', $service->department_id ?? '') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="price" class="form-label">Price</label>
            <input id="price" name="price" type="number" step="0.01" min="0"
                value="{{ old('price', $service->price ?? '') }}" class="form-control">
        </div>
        <div class="col-12">
            <label for="short_description" class="form-label">Short description</label>
            <input id="short_description" name="short_description" type="text"
                value="{{ old('short_description', $service->short_description ?? '') }}" class="form-control">
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="5" class="form-control">{{ old('description', $service->description ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Image {{ $method ?? false ? '(optional)' : '' }}</label>
            @if (isset($service) && $service->media)
                <div class="mb-3"><img src="{{ asset($service->media->path) }}" alt="{{ $service->name }}"
                        class="rounded" style="width: 120px; height: 120px; object-fit: cover;"></div>
            @endif
            <input id="image" name="image" type="file" accept="image/*" class="form-control">
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check">
                <input id="service-status" name="status" type="checkbox" value="1" class="form-check-input"
                    @checked(old('status', $service->status ?? true))>
                <label for="service-status" class="form-check-label">Active</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $cancel }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save service</button>
    </div>
</form>
