<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeUser extends Model
{
    protected $primaryKey = 'id';

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'code',
        'user_id',
    ];

    protected $foreignKey = ['user_id'];

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}
