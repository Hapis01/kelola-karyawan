<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = ['nama'];
    public $timestamps = false;

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
