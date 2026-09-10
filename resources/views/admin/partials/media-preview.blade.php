@if ($media)
    <img src="{{ asset($media->path) }}" alt="{{ $label }}" class="rounded-circle mb-4"
        style="width: 180px; height: 180px; object-fit: cover;">
@endif
