<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = ['task','comments','project_id','status_id','assigned_by','user_id'];

	public function project()
	{
     return $this->belongsTo('App\Project');    
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function assigned_by_user()
    {
        return $this->belongsTo('App\User','assigned_by');
    }

    
    protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];
}
