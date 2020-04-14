<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['activity','user_id'];  

    public function user()
    {
        return $this->belongsTo('App\User');
    }

      protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];

}
