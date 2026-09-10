@include('admin.partials.form-errors')
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-4">
    @csrf @if ($method ?? false)
        @method($method)
    @endif
    <div class="col-md-6"><label class="form-label">Patient name</label><input name="patient_name"
            value="{{ old('patient_name', $testimonial->patient_name ?? '') }}" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Patient title</label><input name="patient_title"
            value="{{ old('patient_title', $testimonial->patient_title ?? '') }}" class="form-control"></div>
    <div class="col-12"><label class="form-label">Testimonial</label>
        <textarea name="content" rows="5" class="form-control" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
    </div>
    <div class="col-md-4"><label class="form-label">Rating</label><input type="number" min="1" max="5"
            name="rating" value="{{ old('rating', $testimonial->rating ?? 5) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Sort order</label><input type="number" min="0"
            name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">Image {{ $method ?? false ? '(optional)' : '' }}</label>
        @if (isset($testimonial) && $testimonial->media)
            <div class="mb-3"><img src="{{ asset($testimonial->media->path) }}" alt="{{ $testimonial->patient_name }}"
                    class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;"></div>
        @endif
        <input type="file" name="image" accept="image/*" class="form-control"
            {{ $method ?? false ? '' : 'required' }}>
    </div>
    <div class="col-12">
        <div class="form-check"><input type="checkbox" name="status" value="1" class="form-check-input"
                id="testimonial-status" @checked(old('status', $testimonial->status ?? true))><label class="form-check-label"
                for="testimonial-status">Active</label></div>
    </div>
    <div class="col-12 d-flex gap-2"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save</button><a
            href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
