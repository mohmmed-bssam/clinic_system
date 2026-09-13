<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.appointments.index', [
            'appointments' => Appointment::with(['patient', 'doctor', 'department'])
                ->latest('appointment_at')
                ->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.appointments.create', [
            'patients' => User::where('role', 'patient')->orderBy('name')->get(),
            'doctors' => Doctor::with('department')->where('status', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_id' => ['nullable', 'exists:users,id'],
            'new_patient_name' => ['nullable', 'required_without:patient_id', 'string', 'max:255'],
            'new_patient_email' => ['nullable', 'required_without:patient_id', 'email', 'max:255', 'unique:users,email'],
            'new_patient_password' => ['nullable', 'required_without:patient_id', 'confirmed', Password::defaults()],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_at' => ['required', 'date_format:Y-m-d\\TH:i'],
        ]);

        $patient = $data['patient_id']
            ? User::where('role', 'patient')->findOrFail($data['patient_id'])
            : null;
        $doctor = Doctor::with('schedules')->where('status', true)->findOrFail($data['doctor_id']);
        $appointmentAt = Carbon::createFromFormat('Y-m-d\\TH:i', $data['appointment_at']);
        $schedule = $doctor->schedules->firstWhere('day_of_week', $appointmentAt->dayOfWeek);

        if ($appointmentAt->isPast()) {
            return back()->withErrors(['appointment_at' => 'Please choose a future appointment time.'])->withInput();
        }

        if (
            $schedule === null
            || $appointmentAt->format('H:i:s') < $schedule->starts_at
            || $appointmentAt->copy()->addMinutes($schedule->slot_minutes)->format('H:i:s') > $schedule->ends_at
        ) {
            return back()->withErrors(['appointment_at' => 'The doctor is not available at the selected time.'])->withInput();
        }

        $alreadyBooked = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->where('appointment_at', $appointmentAt)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['appointment_at' => 'This time is already booked.'])->withInput();
        }

        DB::transaction(function () use ($data, $doctor, $appointmentAt, &$patient): void {
            if ($patient === null) {
                $patient = User::create([
                    'name' => $data['new_patient_name'],
                    'email' => $data['new_patient_email'],
                    'password' => Hash::make($data['new_patient_password']),
                    'role' => 'patient',
                ]);
            }

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'department_id' => $doctor->department_id,
                'appointment_at' => $appointmentAt,
                'status' => 'confirmed',
            ]);
        });

        flash()->success('Appointment created successfully');

        return Redirect::route('admin.appointments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): View
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment->load(['patient', 'doctor', 'department']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->update($data);
        flash()->info('Appointment updated successfully');

        return Redirect::route('admin.appointments.show', $appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
