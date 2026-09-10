@php($entity = $entity ?? null)
@include('admin.partials.form-errors')
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-4">
    @csrf
    @if ($method ?? false)
        @method($method)
    @endif
    <div class="col-md-6"><label class="form-label">Name</label><input name="name"
            value="{{ old('name', $entity->name ?? '') }}" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Slug</label><input name="slug"
            value="{{ old('slug', $entity->slug ?? '') }}" class="form-control" required></div>
    @if ($entityType === 'service' || $entityType === 'doctor')
        <div class="col-md-6"><label class="form-label">Department</label><select name="department_id"
                class="form-select" required>
                <option value="">Select department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $entity->department_id ?? '') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select></div>
    @endif
    @if ($entityType === 'service')
        <div class="col-md-6"><label class="form-label">Price</label><input type="number" step="0.01" min="0"
                name="price" value="{{ old('price', $entity->price ?? '') }}" class="form-control"></div>
    @endif
    @if ($entityType === 'doctor')
        <div class="col-md-6"><label class="form-label">Specialization</label><input name="specialization"
                value="{{ old('specialization', $entity->specialization ?? '') }}" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email"
                value="{{ old('email', $entity->email ?? '') }}" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone"
                value="{{ old('phone', $entity->phone ?? '') }}" class="form-control"></div>
    @endif
    @if ($entityType === 'department' || $entityType === 'service')
        <div class="col-12"><label class="form-label">Short description</label><input name="short_description"
                value="{{ old('short_description', $entity->short_description ?? '') }}" class="form-control"></div>
    @endif
    @if ($entityType === 'department' || $entityType === 'service' || $entityType === 'doctor')
        <div class="col-12"><label class="form-label">Description / Bio</label>
            <textarea name="{{ $entityType === 'doctor' ? 'bio' : 'description' }}" rows="5" class="form-control">{{ old($entityType === 'doctor' ? 'bio' : 'description', $entity->{$entityType === 'doctor' ? 'bio' : 'description'} ?? '') }}</textarea>
        </div>
    @endif
    <div class="col-md-6">
        <label class="form-label">Image {{ $method ?? false ? '(optional)' : '' }}</label>
        @if ($entity?->media)
            <div class="mb-3">
                <img src="{{ asset($entity->media->path) }}" alt="{{ $entity->name }}" class="rounded"
                    style="width: 120px; height: 120px; object-fit: cover;">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*"
            {{ $method ?? false ? '' : 'required' }}>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check"><input type="checkbox" name="status" value="1" class="form-check-input"
                id="status" @checked(old('status', $entity->status ?? true))><label for="status"
                class="form-check-label">Active</label></div>
    </div>
    <div class="col-12 d-flex gap-2"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save</button><a
            href="{{ $cancel }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
