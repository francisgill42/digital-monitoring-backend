<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['client'];

        protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];
    
}
