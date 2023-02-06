<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
        'password'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'username',
        'email',
        'password',
        'level',
        'logged',
        'user_id'
    ];

    public function token() {
        return $this->hasOne('Token', 'user_id', 'id');
    }

    public function codeUser() {
        return $this->hasOne('CodeUser', 'user_id', 'id');
    }

    static public function validateUser(int $id): bool {
        $user = self::findOrFail($id);
        if (($user !== null || $user !== false) && count($user->toArray()) >= 1) {
            return true;
        }
        return false;
    }
}