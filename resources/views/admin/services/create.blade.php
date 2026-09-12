<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New Service',
        'subtitle' => 'Add a medical service.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.services._form', [
                'action' => route('admin.services.store'),
                'cancel' => route('admin.services.index'),
                'departments' => $departments,
            ])
        </div>
    </div>
</x-admin-layout>
