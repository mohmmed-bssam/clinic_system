<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Messages',
        'subtitle' => 'Review messages sent by visitors.',
    ])<div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td><strong>{{ $message->name }}</strong>
                                <div class="small text-muted">{{ $message->email }}</div>
                            </td>
                            <td>{{ $message->subject }}</td>
                            <td><span
                                    class="badge {{ $message->status === 'read' ? 'bg-secondary' : 'bg-warning' }}">{{ ucfirst($message->status) }}</span>
                            </td>
                            <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                            <td class="text-end"><a href="{{ route('admin.messages.show', $message) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                @include('admin.partials.delete-form', [
                                    'action' => route('admin.messages.destroy', $message),
                                ])</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="text-center py-5 text-muted">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $messages->links() }}</div>
    </div></x-admin-layout>
