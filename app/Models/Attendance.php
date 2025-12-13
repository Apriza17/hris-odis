<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Karyawan
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
