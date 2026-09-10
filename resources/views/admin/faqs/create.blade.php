<x-admin-layout>@include('admin.partials.page-header', [
    'title' => 'New FAQ',
    'subtitle' => 'Add a frequently asked question.',
])<div class="card p-4">@include('admin.partials.faq-form', ['action' => route('admin.faqs.store')])</div></x-admin-layout>
