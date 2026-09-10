@include('admin.partials.crud-form-page', [
    'title' => 'New Service',
    'subtitle' => 'Add a medical service.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.services.store'),
        'cancel' => route('admin.services.index'),
        'entityType' => 'service',
        'departments' => $departments,
    ],
])
