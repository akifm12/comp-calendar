<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceRequirement extends Model
{
    protected $fillable = ['title','description','regulator_id','license_activity_id','frequency','category','submission_channel','penalty_note','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function regulator() { return $this->belongsTo(Regulator::class); }
    public function licenseActivity() { return $this->belongsTo(LicenseActivity::class); }
    public function deadlines() { return $this->hasMany(ComplianceDeadline::class, 'requirement_id'); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
