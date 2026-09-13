<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppointmentBookingController extends Controller
{
    public function create(): View
    {
        abort_unless(auth()->user()->role === 'patient', 403);

        return view('appointments.create', [
            'doctors' => Doctor::with('department')
                ->where('status', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role === 'patient', 403);

        $data = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_at' => ['required', 'date_format:Y-m-d\\TH:i'],
        ]);

        $doctor = Doctor::with('schedules')->where('status', true)->findOrFail($data['doctor_id']);
        $appointmentAt = Carbon::createFromFormat('Y-m-d\\TH:i', $data['appointment_at']);
        $schedule = $doctor->schedules->firstWhere('day_of_week', $appointmentAt->dayOfWeek);

        if ($appointmentAt->isPast()) {
            return back()->withErrors(['appointment_at' => 'Please choose a future appointment time.'])->withInput();
        }

        if ($schedule === null
            || $appointmentAt->format('H:i:s') < $schedule->starts_at
            || $appointmentAt->copy()->addMinutes($schedule->slot_minutes)->format('H:i:s') > $schedule->ends_at) {
            return back()->withErrors(['appointment_at' => 'This doctor is not available at the selected time.'])->withInput();
        }

        $alreadyBooked = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->where('appointment_at', $appointmentAt)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['appointment_at' => 'This time is already booked.'])->withInput();
        }

        Appointment::create([
            'patient_id' => $request->user()->id,
            'doctor_id' => $doctor->id,
            'department_id' => $doctor->department_id,
            'appointment_at' => $appointmentAt,
            'status' => 'pending',
        ]);

        return Redirect::route('appointments.create')->with('status', 'appointment-created');
    }
}
