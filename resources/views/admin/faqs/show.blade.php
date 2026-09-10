<x-admin-layout>@include('admin.partials.page-header', ['title' => $faq->question, 'subtitle' => 'FAQ details.'])<div class="card p-4">
        <h3 class="h5">{{ $faq->question }}</h3>
        <p class="mt-3">{{ $faq->answer }}</p><a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-primary"><i
                class="bi bi-pencil"></i> Edit</a>
    </div></x-admin-layout>
