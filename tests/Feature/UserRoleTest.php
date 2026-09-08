<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;

it('adds a patient role by default', function () {
    expect(Schema::hasColumn('users', 'role'))->toBeTrue();

    $user = User::factory()->create();

    expect($user->role)->toBe('patient');
});

it('allows supported user roles', function () {
    $user = User::factory()->create(['role' => 'doctor']);

    expect($user->role)->toBe('doctor');
});
