<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New Doctor',
        'subtitle' => 'Add a doctor to your team.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.doctors._form', [
                'action' => route('admin.doctors.store'),
                'cancel' => route('admin.doctors.index'),
                'departments' => $departments,
            ])
        </div>
    </div>
</x-admin-layout>
