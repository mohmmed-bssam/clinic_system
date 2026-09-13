<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
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
            'email' => ['required', 'email', 'max:255', 'unique:doctors,email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['required', 'image', 'max:2048'],
            'schedule' => ['nullable', 'array'],
            'schedule.*.starts_at' => ['required_with:schedule.*.enabled', 'date_format:H:i'],
            'schedule.*.ends_at' => ['required_with:schedule.*.enabled', 'date_format:H:i', 'after:schedule.*.starts_at'],
        ]);
        $data['status'] = $request->boolean('status');

        $image = $data['image'];
        unset($data['image'], $data['password'], $data['schedule']);

        DB::transaction(function () use ($data, $image, $request): void {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($request->string('password')->toString()),
                'role' => 'doctor',
            ]);

            $doctor = Doctor::create([...$data, 'user_id' => $user->id]);
            $this->saveSchedule($doctor, $request->input('schedule', []));

            Media::create([
                'path' => $image->store('uploads/doctors', 'custom'),
                'type' => $image->getMimeType(),
                'mediable_id' => $doctor->id,
                'mediable_type' => Doctor::class,
            ]);
        });

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
            'email' => ['required', 'email', 'max:255', Rule::unique('doctors', 'email')->ignore($doctor), Rule::unique('users', 'email')->ignore($doctor->user_id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
            'schedule' => ['nullable', 'array'],
            'schedule.*.starts_at' => ['required_with:schedule.*.enabled', 'date_format:H:i'],
            'schedule.*.ends_at' => ['required_with:schedule.*.enabled', 'date_format:H:i', 'after:schedule.*.starts_at'],
        ]);
        $data['status'] = $request->boolean('status');

        unset($data['image'], $data['schedule']);

        $doctor->update($data);
        $this->saveSchedule($doctor, $request->input('schedule', []));

        if ($doctor->user !== null) {
            $doctor->user->update([
                'name' => $doctor->name,
                'email' => $doctor->email,
            ]);
        }

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

        flash()->info('Doctor updated successfully');

        return Redirect::route('admin.doctors.index');
    }

    private function saveSchedule(Doctor $doctor, array $schedule): void
    {
        $doctor->schedules()->delete();

        foreach ($schedule as $day => $hours) {
            if (empty($hours['enabled'])) {
                continue;
            }

            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => (int) $day,
                'starts_at' => $hours['starts_at'],
                'ends_at' => $hours['ends_at'],
                'slot_minutes' => 30,
            ]);
        }
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
        flash()->warning('Doctor deleted successfully');

        return Redirect::route('admin.doctors.index');
    }
}
