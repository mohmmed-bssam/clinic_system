<?php

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;

it('deactivates a department when the status checkbox is unchecked', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    $department = Department::create([
        'name' => 'Cardiology',
        'slug' => 'cardiology',
        'status' => true,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.departments.update', $department), [
        'name' => 'Cardiology',
        'slug' => 'cardiology',
    ]);

    $response->assertRedirect(route('admin.departments.index'));
    expect($department->refresh()->status)->toBe(0);
});

it('deactivates a doctor when the status checkbox is unchecked', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    $department = Department::create([
        'name' => 'Cardiology',
        'slug' => 'cardiology',
        'status' => true,
    ]);
    $doctor = Doctor::create([
        'department_id' => $department->id,
        'name' => 'Dr. Ahmed Ali',
        'slug' => 'dr-ahmed-ali',
        'status' => true,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.doctors.update', $doctor), [
        'department_id' => $department->id,
        'name' => 'Dr. Ahmed Ali',
        'slug' => 'dr-ahmed-ali',
    ]);

    $response->assertRedirect(route('admin.doctors.index'));
    expect($doctor->refresh()->status)->toBe(0);
});
