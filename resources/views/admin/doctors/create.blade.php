@include('admin.partials.crud-form-page', [
    'title' => 'New Doctor',
    'subtitle' => 'Add a doctor to your team.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.doctors.store'),
        'cancel' => route('admin.doctors.index'),
        'entityType' => 'doctor',
        'departments' => $departments,
    ],
])
