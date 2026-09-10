<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Services',
        'subtitle' => 'Manage medical services.',
        'action' => ['url' => route('admin.services.create'), 'label' => 'New Service', 'icon' => 'bi-plus-lg'],
    ])
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Services</h2><span class="text-muted-green">{{ $services->total() }} records</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">@include('admin.partials.media-thumbnail', [
                                    'media' => $service->media,
                                    'label' => $service->name,
                                    'icon' => 'bi-heart-pulse',
                                ])<div>
                                        <strong>{{ $service->name }}</strong>
                                        <div class="small text-muted">{{ $service->short_description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $service->department->name }}</td>
                            <td>{{ $service->price !== null ? number_format($service->price, 2) : '-' }}</td>
                            <td><span
                                    class="badge {{ $service->status ? 'bg-success' : 'bg-secondary' }}">{{ $service->status ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.services.show', $service) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a> <a
                                    href="{{ route('admin.services.edit', $service) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @include('admin.partials.delete-form', [
                                    'action' => route('admin.services.destroy', $service),
                                ])</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="text-center py-5 text-muted">No services found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $services->links() }}</div>
    </div>
</x-admin-layout>
