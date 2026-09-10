<?php

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

it('defines the department relationships', function () {
    $department = new Department;

    expect($department->doctors())
        ->toBeInstanceOf(HasMany::class)
        ->and($department->doctors()->getRelated())->toBeInstanceOf(Doctor::class)
        ->and($department->services())
        ->toBeInstanceOf(HasMany::class)
        ->and($department->services()->getRelated())->toBeInstanceOf(Service::class)
        ->and($department->media())
        ->toBeInstanceOf(MorphOne::class)
        ->and($department->media()->getRelated())->toBeInstanceOf(Media::class);
});
