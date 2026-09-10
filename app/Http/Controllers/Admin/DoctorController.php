<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.doctors.index', [
            'doctors' => Doctor::with(['department', 'media'])->latest()->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.doctors.create', ['departments' => Department::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:doctors,slug'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:doctors,email'],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $image = $data['image'];
        unset($data['image']);

        $doctor = Doctor::create($data);

        Media::create([
            'path' => $image->store('uploads/doctors', 'custom'),
            'type' => $image->getMimeType(),
            'mediable_id' => $doctor->id,
            'mediable_type' => Doctor::class,
        ]);

        flash()->success('Doctor created successfully');

        return Redirect::route('admin.doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor): View
    {
        $doctor->load(['department', 'media']);

        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): View
    {
        return view('admin.doctors.edit', [
            'doctor' => $doctor,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('doctors', 'slug')->ignore($doctor)],
            'specialization' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('doctors', 'email')->ignore($doctor)],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        unset($data['image']);

        $doctor->update($data);

        if ($request->hasFile('image')) {
            $media = $doctor->media()->first();

            if ($media !== null) {
                File::delete(public_path($media->path));
            }

            $path = $request->file('image')->store('uploads/doctors', 'custom');

            if ($media !== null) {
                $media->update([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                ]);
            } else {
                Media::create([
                    'path' => $path,
                    'type' => $request->file('image')->getMimeType(),
                    'mediable_id' => $doctor->id,
                    'mediable_type' => Doctor::class,
                ]);
            }
        }

        flash()->success('Doctor updated successfully');

        return Redirect::route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor): RedirectResponse
    {
        $media = $doctor->media()->first();

        if ($media !== null) {
            File::delete(public_path($media->path));
            $media->delete();
        }

        $doctor->delete();
        flash()->success('Doctor deleted successfully');

        return Redirect::route('admin.doctors.index');
    }
}
