<x-admin-layout>@include('admin.partials.page-header', ['title' => 'Edit FAQ', 'subtitle' => 'Update this answer.'])<div class="card p-4">@include('admin.partials.faq-form', [
    'action' => route('admin.faqs.update', $faq),
    'method' => 'PUT',
    'faq' => $faq,
])</div></x-admin-layout>
