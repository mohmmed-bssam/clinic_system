<?php

use App\Models\User;

it('allows admins to view the admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertViewIs('admin.dashboard')
        ->assertViewHas('patientsCount', 0);
});

it('denies non-admin users access to the admin dashboard', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});
