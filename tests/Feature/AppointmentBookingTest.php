<?php

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Support\Carbon;

function bookingDoctor(): Doctor
{
    $department = Department::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
    $doctor = Doctor::create([
        'department_id' => $department->id,
        'name' => 'Dr. Schedule',
        'slug' => 'dr-schedule',
        'status' => true,
    ]);

    DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'day_of_week' => 0,
        'starts_at' => '15:00',
        'ends_at' => '18:00',
        'slot_minutes' => 30,
    ]);

    return $doctor;
}

it('allows an admin to schedule a patient inside the doctors working hours', function () {
    Carbon::setTestNow('2026-09-13 12:00:00');
    $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    $patient = User::factory()->create(['role' => 'patient', 'email_verified_at' => now()]);
    $doctor = bookingDoctor();

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_at' => '2026-09-13T15:00',
    ])->assertRedirect(route('admin.appointments.index'));

    expect(Appointment::first()->status)->toBe('confirmed');
});

it('rejects admin appointments outside working hours and duplicate times', function () {
    Carbon::setTestNow('2026-09-13 12:00:00');
    $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    $patient = User::factory()->create(['role' => 'patient', 'email_verified_at' => now()]);
    $doctor = bookingDoctor();

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_at' => '2026-09-13T14:30',
    ])->assertSessionHasErrors('appointment_at');

    Appointment::create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'department_id' => $doctor->department_id,
        'appointment_at' => '2026-09-13 15:00:00',
        'status' => 'pending',
    ]);

    $this->actingAs($admin)->post(route('admin.appointments.store'), [
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_at' => '2026-09-13T15:00',
    ])->assertSessionHasErrors('appointment_at');
});

it('creates a pending request for a patient and lets an admin approve it', function () {
    Carbon::setTestNow('2026-09-13 12:00:00');
    $patient = User::factory()->create(['role' => 'patient', 'email_verified_at' => now()]);
    $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    $doctor = bookingDoctor();

    $this->actingAs($patient)->post(route('appointments.store'), [
        'doctor_id' => $doctor->id,
        'appointment_at' => '2026-09-13T16:00',
    ])->assertRedirect(route('appointments.create'));

    $appointment = Appointment::firstOrFail();
    expect($appointment->status)->toBe('pending');

    $this->actingAs($admin)->put(route('admin.appointments.update', $appointment), [
        'status' => 'confirmed',
        'notes' => 'Approved by reception',
    ])->assertRedirect(route('admin.appointments.show', $appointment));

    expect($appointment->fresh()->status)->toBe('confirmed');
});
