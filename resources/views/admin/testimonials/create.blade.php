<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New Testimonial',
        'subtitle' => 'Add patient feedback.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.testimonials._form', ['action' => route('admin.testimonials.store')])
        </div>
    </div>
</x-admin-layout>
