<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nik',
        'training_name',
        'training_date',
        'training_provider',
        'certificate_file',
        'description',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'training_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Relasi ke Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }

    /**
     * Relasi ke User yang approve
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
