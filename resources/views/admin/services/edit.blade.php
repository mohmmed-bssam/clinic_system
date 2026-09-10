@include('admin.partials.crud-form-page', [
    'title' => 'Edit Service',
    'subtitle' => 'Update service information.',
    'formView' => 'admin.partials.entity-form',
    'formData' => [
        'action' => route('admin.services.update', $service),
        'method' => 'PUT',
        'cancel' => route('admin.services.index'),
        'entityType' => 'service',
        'entity' => $service,
        'departments' => $departments,
    ],
])
