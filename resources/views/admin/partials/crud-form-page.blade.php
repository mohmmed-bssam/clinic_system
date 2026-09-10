<x-admin-layout>
    @include('admin.partials.page-header', ['title' => $title, 'subtitle' => $subtitle ?? null])
    <div class="card">
        <div class="p-4">@include($formView, $formData)</div>
    </div>
</x-admin-layout>
