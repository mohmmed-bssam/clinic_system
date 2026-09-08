<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('creates the departments table with the expected fields', function () {
    expect(Schema::hasColumns('departments', [
        'id',
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'status',
        'created_at',
        'updated_at',
    ]))->toBeTrue();

    DB::table('departments')->insert([
        'name' => 'Neurology',
        'slug' => 'neurology',
    ]);

    expect(DB::table('departments')->where('slug', 'neurology')->value('status'))->toBe(1);
});
