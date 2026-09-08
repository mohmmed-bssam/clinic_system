<?php

use Illuminate\Support\Facades\Schema;

it('creates the polymorphic media table', function () {
    expect(Schema::hasColumns('media', [
        'id',
        'file_name',
        'file_path',
        'mime_type',
        'mediable_id',
        'mediable_type',
        'created_at',
        'updated_at',
        'size',
    ]))->toBeTrue();
});
