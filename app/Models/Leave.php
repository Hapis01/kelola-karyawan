<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nik',
        'leave_type',
        'start_date',
        'end_date',
        'days_count',
        'reason',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
     * Hitung jumlah hari otomatis
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->days_count = $model->start_date->diffInDays($model->end_date) + 1;
        });

        static::updating(function ($model) {
            $model->days_count = $model->start_date->diffInDays($model->end_date) + 1;
        });
    }
}
