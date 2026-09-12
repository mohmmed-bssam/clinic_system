<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Edit FAQ', 'subtitle' => 'Update this answer.'])

    <div class="card">
        <div class="p-4">
            @include('admin.faqs._form', [
                'action' => route('admin.faqs.update', $faq),
                'method' => 'PUT',
                'faq' => $faq,
            ])
        </div>
    </div>
</x-admin-layout>
