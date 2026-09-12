<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Edit Service',
        'subtitle' => 'Update service information.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.services._form', [
                'action' => route('admin.services.update', $service),
                'method' => 'PUT',
                'cancel' => route('admin.services.index'),
                'service' => $service,
                'departments' => $departments,
            ])
        </div>
    </div>
</x-admin-layout>
