<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Doctors',
        'subtitle' => 'Manage the medical team.',
        'action' => ['url' => route('admin.doctors.create'), 'label' => 'New Doctor', 'icon' => 'bi-plus-lg'],
    ])
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Doctors</h2><span class="text-muted-green">{{ $doctors->total() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">@include('admin.partials.media-thumbnail', [
                                    'media' => $doctor->media,
                                    'label' => $doctor->name,
                                    'icon' => 'bi-person-badge',
                                ])<div>
                                        <strong>{{ $doctor->name }}</strong>
                                        <div class="small text-muted">{{ $doctor->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $doctor->specialization ?: '-' }}</td>
                            <td>{{ $doctor->department->name }}</td>
                            <td><span
                                    class="badge {{ $doctor->status ? 'bg-success' : 'bg-secondary' }}">{{ $doctor->status ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.doctors.show', $doctor) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a> <a
                                    href="{{ route('admin.doctors.edit', $doctor) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @include('admin.partials.delete-form', [
                                    'action' => route('admin.doctors.destroy', $doctor),
                                ])</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="text-center py-5 text-muted">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $doctors->links() }}</div>
    </div>
</x-admin-layout>
