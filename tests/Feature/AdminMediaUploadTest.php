<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores a department image in the polymorphic media table', function () {
    Storage::fake('custom');

    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($admin)->post(route('admin.departments.store'), [
        'name' => 'Cardiology',
        'slug' => 'cardiology',
        'image' => UploadedFile::fake()->image('cardiology.jpg'),
    ]);

    $response->assertRedirect(route('admin.departments.index'));

    $department = Department::query()->where('slug', 'cardiology')->firstOrFail();
    $media = $department->media()->firstOrFail();

    expect($media->mediable_type)->toBe($department::class);
    Storage::disk('custom')->assertExists($media->path);
});
