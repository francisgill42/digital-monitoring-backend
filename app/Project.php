<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','client_id','status_id','comments','user_id','start_date','end_date'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
        public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function progress()
    {
        return $this->hasOne('App\Progress')->orderBy('id', 'DESC')->first();
    }



        protected $casts = [
        'created_at' => 'datetime:d-M-y',
        'start_date' => 'datetime:d-M-y',
        'end_date' => 'datetime:d-M-y',
        // 'user_id' => 'array'
        ];


}