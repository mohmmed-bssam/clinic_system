<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Departments',
        'subtitle' => 'Manage clinic departments.',
        'action' => [
            'url' => route('admin.departments.create'),
            'label' => 'New Department',
            'icon' => 'bi-plus-lg',
        ],
    ])
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Departments</h2><span class="text-muted-green">{{ $departments->total() }}
                records</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">@include('admin.partials.media-thumbnail', [
                                    'media' => $department->media,
                                    'label' => $department->name,
                                    'icon' => 'bi-diagram-3',
                                ])<div>
                                        <strong>{{ $department->name }}</strong>
                                        <div class="small text-muted">{{ $department->short_description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $department->slug }}</td>
                            <td><span
                                    class="badge {{ $department->status ? 'bg-success' : 'bg-secondary' }}">{{ $department->status ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.departments.show', $department) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a> <a
                                    href="{{ route('admin.departments.edit', $department) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @include('admin.partials.delete-form', [
                                    'action' => route('admin.departments.destroy', $department),
                                ])</td>
                    </tr>@empty<tr>
                            <td colspan="4" class="text-center py-5 text-muted">No departments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $departments->links() }}</div>
    </div>
</x-admin-layout>
