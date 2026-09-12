<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Edit Doctor',
        'subtitle' => 'Update doctor information.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.doctors._form', [
                'action' => route('admin.doctors.update', $doctor),
                'method' => 'PUT',
                'cancel' => route('admin.doctors.index'),
                'doctor' => $doctor,
                'departments' => $departments,
            ])
        </div>
    </div>
</x-admin-layout>
