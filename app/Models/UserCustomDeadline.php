<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCustomDeadline extends Model
{
    protected $fillable = [
        'user_id', 'profile_id', 'title', 'due_date',
        'notes', 'category', 'is_recurring', 'recurrence',
    ];

    protected $casts = [
        'due_date'     => 'date',
        'is_recurring' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
