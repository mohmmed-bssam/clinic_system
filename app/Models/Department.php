<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Department extends Model
{
    protected $guarded = [];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
