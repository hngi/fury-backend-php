<?php

namespace App\v1;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['user_id', 'employee_id', 'event_id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
