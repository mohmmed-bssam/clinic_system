<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $doctor = $request->user()->doctor;
        $appointments = Appointment::query()
            ->with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_at', Carbon::today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_at')
            ->get();
        $nextAppointment = $appointments->first(function (Appointment $appointment): bool {
            return in_array($appointment->status, ['pending', 'confirmed'], true)
                && $appointment->appointment_at->isFuture();
        });

        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'appointments' => $appointments,
            'nextAppointment' => $nextAppointment,
            'waitingCount' => $appointments->whereIn('status', ['pending', 'confirmed'])->count(),
            'completedCount' => $appointments->where('status', 'completed')->count(),
        ]);
    }
}
