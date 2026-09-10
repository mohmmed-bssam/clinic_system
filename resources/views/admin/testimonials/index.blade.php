<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Testimonials',
        'subtitle' => 'Manage patient feedback.',
        'action' => [
            'url' => route('admin.testimonials.create'),
            'label' => 'New Testimonial',
            'icon' => 'bi-plus-lg',
        ],
    ])<div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Testimonial</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">@include('admin.partials.media-thumbnail', [
                                    'media' => $testimonial->media,
                                    'label' => $testimonial->patient_name,
                                    'icon' => 'bi-person',
                                ])<div>
                                        <strong>{{ $testimonial->patient_name }}</strong>
                                        <div class="small text-muted">{{ $testimonial->patient_title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ Str::limit($testimonial->content, 80) }}</td>
                            <td>{{ str_repeat('★', $testimonial->rating ?: 0) }}</td>
                            <td><span
                                    class="badge {{ $testimonial->status ? 'bg-success' : 'bg-secondary' }}">{{ $testimonial->status ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.testimonials.show', $testimonial) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a> <a
                                    href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @include('admin.partials.delete-form', [
                                    'action' => route('admin.testimonials.destroy', $testimonial),
                                ])</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="text-center py-5 text-muted">No testimonials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $testimonials->links() }}</div>
    </div></x-admin-layout>
