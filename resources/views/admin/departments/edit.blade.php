@include('admin.partials.crud-form-page', [
    'title' => 'Edit Department',
    'subtitle' => 'Update department information.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.departments.update', $department),
        'method' => 'PUT',
        'cancel' => route('admin.departments.index'),
        'entityType' => 'department',
        'entity' => $department,
    ],
])
