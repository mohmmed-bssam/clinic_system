@include('admin.partials.crud-form-page', [
    'title' => 'New Department',
    'subtitle' => 'Add a clinic department.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.departments.store'),
        'cancel' => route('admin.departments.index'),
        'entityType' => 'department',
    ],
])
