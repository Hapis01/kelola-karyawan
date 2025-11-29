<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table = 'user_histories';

    protected $fillable = [
        'user_id',
        'user_email',
        'action',
        'old_data',
        'new_data',
        'admin_id',
        'created_at'
    ];

    protected $casts = [
        'old_data' => 'json',
        'new_data' => 'json',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
