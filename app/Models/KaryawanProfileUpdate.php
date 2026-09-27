<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanProfileUpdate extends Model
{
    use HasFactory;

    protected $table = 'karyawan_profile_updates';

    protected $fillable = [
        'nik',
        'field_name',
        'old_value',
        'new_value',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
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

    /**
     * Scope untuk pending updates
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
