<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceDeadline extends Model
{
    protected $fillable = ['requirement_id','due_date','title','notes','year'];
    protected $casts = ['due_date' => 'date'];

    public function requirement() { return $this->belongsTo(ComplianceRequirement::class, 'requirement_id'); }
    public function scopeForYear($q, int $year) { return $q->where('year', $year); }
    public function scopeUpcoming($q) { return $q->where('due_date', '>=', now()->toDateString()); }
}
