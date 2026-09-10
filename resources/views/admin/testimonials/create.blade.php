<x-admin-layout>@include('admin.partials.page-header', [
    'title' => 'New Testimonial',
    'subtitle' => 'Add patient feedback.',
])<div class="card p-4">@include('admin.partials.testimonial-form', ['action' => route('admin.testimonials.store')])</div></x-admin-layout>
