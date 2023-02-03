<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    protected $guarded = [
        'id',
        'token'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'expire_at'
    ];

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }
}