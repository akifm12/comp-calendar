<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseActivity extends Model
{
    protected $fillable = ['name','description','sector','suggested_regulator_id','additional_regulator_ids','is_active'];
    protected $casts = ['is_active' => 'boolean', 'additional_regulator_ids' => 'array'];

    public function suggestedRegulator() { return $this->belongsTo(Regulator::class, 'suggested_regulator_id'); }
    public function complianceRequirements() { return $this->hasMany(ComplianceRequirement::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
