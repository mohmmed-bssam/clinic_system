<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Edit Testimonial',
        'subtitle' => 'Update patient feedback.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.testimonials._form', [
                'action' => route('admin.testimonials.update', $testimonial),
                'method' => 'PUT',
                'testimonial' => $testimonial,
            ])
        </div>
    </div>
</x-admin-layout>
