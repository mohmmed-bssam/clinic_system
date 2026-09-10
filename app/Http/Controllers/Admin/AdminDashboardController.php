<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()->role === 'admin', 403);

        return view('admin.dashboard', [
            'appointmentsCount' => Appointment::count(),
            'pendingAppointmentsCount' => Appointment::where('status', 'pending')->count(),
            'departmentsCount' => Department::where('status', true)->count(),
            'doctorsCount' => Doctor::where('status', true)->count(),
            'patientsCount' => User::where('role', 'patient')->count(),
        ]);
    }
}
