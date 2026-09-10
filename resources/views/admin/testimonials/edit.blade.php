<x-admin-layout>@include('admin.partials.page-header', [
    'title' => 'Edit Testimonial',
    'subtitle' => 'Update patient feedback.',
])<div class="card p-4">@include('admin.partials.testimonial-form', [
    'action' => route('admin.testimonials.update', $testimonial),
    'method' => 'PUT',
    'testimonial' => $testimonial,
])</div></x-admin-layout>
