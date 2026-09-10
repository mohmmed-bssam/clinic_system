<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'FAQs',
        'subtitle' => 'Manage frequently asked questions.',
        'action' => ['url' => route('admin.faqs.create'), 'label' => 'New FAQ', 'icon' => 'bi-plus-lg'],
    ])<div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td><strong>{{ $faq->question }}</strong></td>
                            <td>{{ Str::limit($faq->answer, 100) }}</td>
                            <td><span
                                    class="badge {{ $faq->status ? 'bg-success' : 'bg-secondary' }}">{{ $faq->status ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="text-end"><a href="{{ route('admin.faqs.show', $faq) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a> <a
                                    href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary"><i
                                        class="bi bi-pencil"></i></a> @include('admin.partials.delete-form', [
                                            'action' => route('admin.faqs.destroy', $faq),
                                        ])</td>
                    </tr>@empty<tr>
                            <td colspan="4" class="text-center py-5 text-muted">No FAQs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $faqs->links() }}</div>
    </div></x-admin-layout>
