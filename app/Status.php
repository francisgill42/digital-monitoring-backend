<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];

        protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];
}
