<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method ?? false)
        @method($method)
    @endif

    <div class="row g-4">
        <div class="col-md-6">
            <label for="patient_name" class="form-label">Patient name</label>
            <input id="patient_name" name="patient_name" type="text"
                value="{{ old('patient_name', $testimonial->patient_name ?? '') }}" class="form-control" autofocus>
            @error('patient_name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="patient_title" class="form-label">Patient title</label>
            <input id="patient_title" name="patient_title" type="text"
                value="{{ old('patient_title', $testimonial->patient_title ?? '') }}" class="form-control">
        </div>
        <div class="col-12">
            <label for="content" class="form-label">Testimonial</label>
            <textarea id="content" name="content" rows="5" class="form-control">{{ old('content', $testimonial->content ?? '') }}</textarea>
            @error('content')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="rating" class="form-label">Rating</label>
            <input id="rating" name="rating" type="number" min="1" max="5"
                value="{{ old('rating', $testimonial->rating ?? 5) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="sort_order" class="form-label">Sort order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="image" class="form-label">Image {{ $method ?? false ? '(optional)' : '' }}</label>
            @if (isset($testimonial) && $testimonial->media)
                <div class="mb-3"><img src="{{ asset($testimonial->media->path) }}"
                        alt="{{ $testimonial->patient_name }}" class="rounded-circle"
                        style="width: 100px; height: 100px; object-fit: cover;"></div>
            @endif
            <input id="image" name="image" type="file" accept="image/*" class="form-control">
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <div class="form-check">
                <input id="testimonial-status" name="status" type="checkbox" value="1" class="form-check-input"
                    @checked(old('status', $testimonial->status ?? true))>
                <label for="testimonial-status" class="form-check-label">Active</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save testimonial</button>
    </div>
</form>
