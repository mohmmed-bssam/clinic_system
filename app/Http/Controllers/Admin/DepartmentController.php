<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.departments.index', [
            'departments' => Department::with('media')->latest()->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:departments,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['required', 'image', 'max:2048'],
        ]);
        $data['status'] = $request->boolean('status');

        $image = $data['image'];
        unset($data['image']);

        $department = Department::create($data);

        Media::create([
            'path' => $image->store('uploads/departments', 'custom'),
            'type' => $image->getMimeType(),
            'mediable_id' => $department->id,
            'mediable_type' => Department::class,
        ]);

        flash()->success('Department created successfully');

        return Redirect::route('admin.departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): View
    {
        $department->load('media');

        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('departments', 'slug')->ignore($department)],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
        $data['status'] = $request->boolean('status');

        unset($data['image']);

        $department->update($data);

        if ($request->hasFile('image')) {
            $media = $department->media()->first();

            if ($media !== null) {
                File::delete(public_path($media->path));
            }

            $path = $request->file('image')->store('uploads/departments', 'custom');

            if ($media !== null) {
                $media->update([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                ]);
            } else {
                Media::create([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                    'mediable_id' => $department->id,
                    'mediable_type' => Department::class,
                ]);
            }
        }

        flash()->info('Department updated successfully');

        return Redirect::route('admin.departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        $media = $department->media()->first();

        if ($media !== null) {
            File::delete(public_path($media->path));
            $media->delete();
        }

        $department->delete();
        flash()->warning('Department deleted successfully');

        return Redirect::route('admin.departments.index');
    }
}