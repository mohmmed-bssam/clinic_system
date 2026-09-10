<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::with(['department', 'media'])->latest()->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.services.create', ['departments' => Department::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:services,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $image = $data['image'];
        unset($data['image']);

        $service = Service::create($data);

        Media::create([
            'path' => $image->store('uploads/services', 'custom'),
            'type' => $image->getMimeType(),
            'mediable_id' => $service->id,
            'mediable_type' => Service::class,
        ]);

        flash()->success('Service created successfully');

        return Redirect::route('admin.services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): View
    {
        $service->load(['department', 'media']);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', [
            'service' => $service,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($service)],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        unset($data['image']);

        $service->update($data);

        if ($request->hasFile('image')) {
            $media = $service->media()->first();

            if ($media !== null) {
                File::delete(public_path($media->path));
            }

            $path = $request->file('image')->store('uploads/services', 'custom');

            if ($media !== null) {
                $media->update([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                ]);
            } else {
                Media::create([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                    'mediable_id' => $service->id,
                    'mediable_type' => Service::class,
                ]);
            }
        }

        flash()->success('Service updated successfully');

        return Redirect::route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $media = $service->media()->first();

        if ($media !== null) {
            File::delete(public_path($media->path));
            $media->delete();
        }

        $service->delete();
        flash()->success('Service deleted successfully');

        return Redirect::route('admin.services.index');
    }
}
