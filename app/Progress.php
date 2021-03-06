<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = ['progress','project_id'];

    public function project()
    {
        return $this->belongsTo('App\Project');

    }

	public function user()
	{
	return $this->hasOneThrough('App\User', 'App\Project');
	}

    protected $casts = [
    	'created_at' => 'datetime:d-M-y',
	];


}
