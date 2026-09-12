<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}