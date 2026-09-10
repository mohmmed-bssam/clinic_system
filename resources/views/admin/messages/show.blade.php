<x-admin-layout>@include('admin.partials.page-header', [
    'title' => $message->subject,
    'subtitle' => 'Message from ' . $message->name,
])<div class="card p-4">
        <p class="text-muted">{{ $message->email }} · {{ $message->created_at->format('M d, Y H:i') }}</p>
        <div class="mt-4">{{ $message->message }}</div>
        <div class="mt-4"><a href="mailto:{{ $message->email }}" class="btn btn-primary"><i class="bi bi-reply"></i>
                Reply</a></div>
    </div></x-admin-layout>
