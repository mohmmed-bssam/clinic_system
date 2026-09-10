<x-admin-layout>@include('admin.partials.page-header', ['title' => $department->name, 'subtitle' => 'Department details.'])<div class="card p-4">@include('admin.partials.media-preview', ['media' => $department->media, 'label' => $department->name])
        <dl class="row mb-0">
            <dt class="col-sm-3">Slug</dt>
            <dd class="col-sm-9">{{ $department->slug }}</dd>
            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $department->description ?: '-' }}</dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ $department->status ? 'Active' : 'Inactive' }}</dd>
        </dl><a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary mt-4"><i
                class="bi bi-pencil"></i> Edit</a>
    </div></x-admin-layout>
