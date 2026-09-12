<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'New FAQ',
        'subtitle' => 'Add a frequently asked question.',
    ])

    <div class="card">
        <div class="p-4">
            @include('admin.faqs._form', ['action' => route('admin.faqs.store')])
        </div>
    </div>
</x-admin-layout>
