<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Settings',
        'subtitle' => 'Manage clinic configuration.',
    ])<div class="row g-4">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Current Settings</h2>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th class="text-end">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings as $setting)
                                <tr>
                                    <form method="POST" action="{{ route('admin.settings.update', $setting) }}">@csrf
                                        @method('PUT')<td><input name="key" value="{{ $setting->key }}"
                                                class="form-control" required></td>
                                        <td><input name="value" value="{{ $setting->value }}" class="form-control">
                                        </td>
                                        <td class="text-end"><button class="btn btn-sm btn-primary"><i
                                                    class="bi bi-check"></i></button></td>
                                    </form>
                            </tr>@empty<tr>
                                    <td colspan="3" class="text-center py-5 text-muted">No settings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card p-4">
                <h2 class="card-title mb-4">Add Setting</h2>@include('admin.partials.form-errors')<form method="POST"
                    action="{{ route('admin.settings.store') }}" class="vstack gap-3">@csrf<input name="key"
                        class="form-control" placeholder="Key" required>
                    <textarea name="value" class="form-control" rows="4" placeholder="Value"></textarea><button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add
                        setting</button>
                </form>
            </div>
        </div>
    </div></x-admin-layout>
