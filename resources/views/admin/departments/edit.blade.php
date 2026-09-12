<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Edit Department',
        'subtitle' => 'Update department information.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.departments._form', [
                'action' => route('admin.departments.update', $department),
                'method' => 'PUT',
                'cancel' => route('admin.departments.index'),
                'department' => $department,
            ])
        </div>
    </div>
</x-admin-layout>
