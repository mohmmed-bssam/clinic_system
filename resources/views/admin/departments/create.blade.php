<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New Department',
        'subtitle' => 'Add a clinic department.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.departments._form', [
                'action' => route('admin.departments.store'),
                'cancel' => route('admin.departments.index'),
            ])
        </div>
    </div>
</x-admin-layout>
