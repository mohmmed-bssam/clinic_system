<x-admin-layout>@include('admin.partials.page-header', [
    'title' => $testimonial->patient_name,
    'subtitle' => 'Testimonial details.',
])<div class="card p-4">@include('admin.partials.media-preview', [
    'media' => $testimonial->media,
    'label' => $testimonial->patient_name,
])
        <p class="lead">{{ $testimonial->content }}</p>
        <p class="text-muted">{{ $testimonial->patient_title }} · {{ str_repeat('★', $testimonial->rating ?: 0) }}</p><a
            href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary"><i
                class="bi bi-pencil"></i> Edit</a>
    </div></x-admin-layout>
