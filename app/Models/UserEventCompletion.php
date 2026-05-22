<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEventCompletion extends Model
{
    protected $fillable = ['user_id', 'profile_id', 'event_key', 'notes', 'completed_at'];

    protected $casts = ['completed_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
}
