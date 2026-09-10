<div class="rounded-circle overflow-hidden flex-shrink-0" style="width: 44px; height: 44px;">
    @if ($media)
        <img src="{{ asset($media->path) }}" alt="{{ $label }}" class="w-100 h-100 object-fit-cover">
    @else
        <i
            class="bi {{ $icon ?? 'bi-image' }} d-flex align-items-center justify-content-center h-100 bg-light text-muted"></i>
    @endif
</div>
