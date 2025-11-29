<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karyawans';

    protected $fillable = [
        'nama',
        'nik',
        'foto',
        'alamat',
        'jenis_kelamin',
        'divisi_id',
        'posisi',
        'gaji',
        'status',
        'keterangan'
    ];

    protected $dates = ['deleted_at'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
