<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'role_id',
        'account_id',
        'password'
    ];
    protected $hidden = [
        'role_id',
        'role',
        'account_id',
        'account',
        'password',
        'userGlobalModel',
        'deleted_at'
    ];
    protected $guarded = [
        'id',
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
        'account_id' => 'integer',
    ];

    public function role() {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function account() {
        return $this->belongsTo('App\Account', 'account_id');
    }

    public function userGlobalModel() {
        return $this->hasOne('App\userGlobalModel', 'user_id');
    }
}
