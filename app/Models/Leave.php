<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Karyawan
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Helper buat label status (biar view-nya bersih)
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
        };
    }
}
