<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        @isset($subtitle)
            <p class="page-subtitle">{{ $subtitle }}</p>
        @endisset
    </div>
    @isset($action)
        <a href="{{ $action['url'] }}" class="btn-quick-action"><i
                class="bi {{ $action['icon'] ?? 'bi-plus-lg' }}"></i><span>{{ $action['label'] }}</span></a>
    @endisset
</div>
