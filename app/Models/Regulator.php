<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulator extends Model
{
    protected $fillable = ['name','acronym','sector','description','logo_url','website','jurisdiction','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function licenseActivities() { return $this->hasMany(LicenseActivity::class, 'suggested_regulator_id'); }
    public function complianceRequirements() { return $this->hasMany(ComplianceRequirement::class); }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
