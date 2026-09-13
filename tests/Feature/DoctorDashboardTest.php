<?php

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

it('creates a doctor login and redirects the doctor to the queue after login', function () {
    Storage::fake('custom');
    $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    $department = Department::create(['name' => 'Cardiology', 'slug' => 'cardiology']);

    $response = $this->actingAs($admin)->post(route('admin.doctors.store'), [
        'department_id' => $department->id,
        'name' => 'Dr. Sara Khalil',
        'slug' => 'dr-sara-khalil',
        'email' => 'sara@example.com',
        'password' => 'StrongPassword123!',
        'password_confirmation' => 'StrongPassword123!',
        'image' => UploadedFile::fake()->image('doctor.jpg'),
    ]);

    $response->assertRedirect(route('admin.doctors.index'));
    $doctorUser = User::where('email', 'sara@example.com')->firstOrFail();
    $doctor = Doctor::where('slug', 'dr-sara-khalil')->firstOrFail();

    expect($doctorUser->role)->toBe('doctor')
        ->and($doctor->user_id)->toBe($doctorUser->id)
        ->and(Hash::check('StrongPassword123!', $doctorUser->password))->toBeTrue();

    Auth::logout();

    $this->post(route('login'), [
        'email' => 'sara@example.com',
        'password' => 'StrongPassword123!',
    ])->assertRedirect(route('doctor.dashboard'));
});

it('shows only the logged in doctors patients in todays queue order', function () {
    Carbon::setTestNow(now()->startOfDay()->addHours(8));
    $department = Department::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
    $doctorUser = User::factory()->create(['role' => 'doctor', 'email_verified_at' => now()]);
    $otherDoctorUser = User::factory()->create(['role' => 'doctor', 'email_verified_at' => now()]);
    $doctor = Doctor::create(['user_id' => $doctorUser->id, 'department_id' => $department->id, 'name' => 'Dr. One', 'slug' => 'dr-one']);
    $otherDoctor = Doctor::create(['user_id' => $otherDoctorUser->id, 'department_id' => $department->id, 'name' => 'Dr. Two', 'slug' => 'dr-two']);
    $firstPatient = User::factory()->create();
    $secondPatient = User::factory()->create();
    $otherPatient = User::factory()->create();

    Appointment::create(['patient_id' => $firstPatient->id, 'doctor_id' => $doctor->id, 'department_id' => $department->id, 'appointment_at' => now()->startOfDay()->addHours(10), 'status' => 'confirmed']);
    Appointment::create(['patient_id' => $secondPatient->id, 'doctor_id' => $doctor->id, 'department_id' => $department->id, 'appointment_at' => now()->startOfDay()->addHours(9), 'status' => 'pending']);
    Appointment::create(['patient_id' => $otherPatient->id, 'doctor_id' => $otherDoctor->id, 'department_id' => $department->id, 'appointment_at' => now()->startOfDay()->addHours(8), 'status' => 'confirmed']);

    $this->actingAs($doctorUser)->get(route('doctor.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([$secondPatient->name, $firstPatient->name])
        ->assertSee('next-appointment-countdown')
        ->assertSee('setInterval(updateCountdown, 1000)')
        ->assertDontSee($otherPatient->name);
});
