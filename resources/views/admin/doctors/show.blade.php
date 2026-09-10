<x-admin-layout>@include('admin.partials.page-header', ['title' => $doctor->name, 'subtitle' => 'Doctor details.'])<div class="card p-4">@include('admin.partials.media-preview', ['media' => $doctor->media, 'label' => $doctor->name])
        <dl class="row mb-0">
            <dt class="col-sm-3">Specialization</dt>
            <dd class="col-sm-9">{{ $doctor->specialization ?: '-' }}</dd>
            <dt class="col-sm-3">Department</dt>
            <dd class="col-sm-9">{{ $doctor->department->name }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $doctor->email ?: '-' }}</dd>
            <dt class="col-sm-3">Bio</dt>
            <dd class="col-sm-9">{{ $doctor->bio ?: '-' }}</dd>
        </dl><a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary mt-4"><i
                class="bi bi-pencil"></i> Edit</a>
    </div></x-admin-layout>
