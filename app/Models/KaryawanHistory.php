<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryawanHistory extends Model
{
    protected $table = 'karyawan_histories';

    protected $fillable = [
        'karyawan_id',
        'karyawan_nama',
        'action',
        'old_data',
        'new_data',
        'user_id',
        'created_at'
    ];

    protected $casts = [
        'old_data' => 'json',
        'new_data' => 'json',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
