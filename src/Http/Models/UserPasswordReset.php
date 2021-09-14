<?php

namespace Sitic\Auth\Http\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sitic\Auth\Http\Traits\Uuids;

class UserPasswordReset extends Model
{
    use Uuids, SoftDeletes;

    protected $fillable = ['user_id', 'old_password', 'new_password', 'code', 'token', 'expired_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
