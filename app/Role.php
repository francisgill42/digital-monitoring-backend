<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

        protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];
}
