<?php

use App\Models\Media;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('defines the testimonial media relationship', function () {
    $testimonial = new Testimonial;

    expect($testimonial->media())
        ->toBeInstanceOf(MorphOne::class)
        ->and($testimonial->media()->getRelated())->toBeInstanceOf(Media::class);
});

it('creates the testimonials table with the expected fields', function () {
    expect(Schema::hasColumns('testimonials', [
        'id',
        'patient_name',
        'patient_title',
        'content',
        'rating',
        'status',
        'sort_order',
        'created_at',
        'updated_at',
    ]))->toBeTrue();

    DB::table('testimonials')->insert([
        'patient_name' => 'Ahmed Ali',
        'content' => 'Excellent care.',
    ]);

    expect(DB::table('testimonials')->where('patient_name', 'Ahmed Ali')->value('status'))->toBe(1);
});

it('defines the patient media relationship', function () {
    $patient = new User;

    expect($patient->media())
        ->toBeInstanceOf(MorphOne::class)
        ->and($patient->media()->getRelated())->toBeInstanceOf(Media::class);
});
it('creates the faqs table with the expected fields', function () {
    expect(Schema::hasColumns('faqs', [
        'id',
        'question',
        'answer',
        'status',
        'sort_order',
        'created_at',
        'updated_at',
    ]))->toBeTrue();

    DB::table('faqs')->insert([
        'question' => 'How do I book an appointment?',
        'answer' => 'Use the appointment form.',
    ]);

    expect(DB::table('faqs')->where('question', 'How do I book an appointment?')->value('status'))->toBe(1);
});
