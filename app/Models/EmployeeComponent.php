<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeComponent extends Model
{
    protected $guarded = ['id'];

    public function component()
    {
        // Relasi ke tabel master biar tau ini tunjangan apa
        return $this->belongsTo(PayrollComponent::class, 'payroll_component_id');
    }
}
