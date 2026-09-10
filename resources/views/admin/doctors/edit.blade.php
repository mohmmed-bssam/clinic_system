@include('admin.partials.crud-form-page', [
    'title' => 'Edit Doctor',
    'subtitle' => 'Update doctor information.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.doctors.update', $doctor),
        'method' => 'PUT',
        'cancel' => route('admin.doctors.index'),
        'entityType' => 'doctor',
        'entity' => $doctor,
        'departments' => $departments,
    ],
])
