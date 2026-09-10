<x-admin-layout>@include('admin.partials.page-header', ['title' => $service->name, 'subtitle' => 'Service details.'])<div class="card p-4">@include('admin.partials.media-preview', ['media' => $service->media, 'label' => $service->name])
        <dl class="row mb-0">
            <dt class="col-sm-3">Department</dt>
            <dd class="col-sm-9">{{ $service->department->name }}</dd>
            <dt class="col-sm-3">Price</dt>
            <dd class="col-sm-9">{{ $service->price !== null ? number_format($service->price, 2) : '-' }}</dd>
            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $service->description ?: '-' }}</dd>
        </dl><a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary mt-4"><i
                class="bi bi-pencil"></i> Edit</a>
    </div></x-admin-layout>
