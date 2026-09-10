<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Testimonial extends Model
{
    protected $guarded = [];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
