<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hero extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
    protected $hidden = [
    ];
    protected $guarded = [
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
    ];
}
