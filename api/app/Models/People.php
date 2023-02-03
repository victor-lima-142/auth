<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $primaryKey = 'id';

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'birthday',
        'position_id',
        'company_id',
        'salary',
        'user_id',
        'percent_promo',
    ];

    protected $foreignKey = ['company_id', 'position_id'];

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}