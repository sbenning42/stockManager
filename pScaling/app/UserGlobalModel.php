<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGlobalModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'state_id',
        'address_id',
        'email',
        'password',
        'username',
        'first_name',
        'last_name',
        'phone',
    ];
    protected $hidden = [
        'id',
        'password',
        'user',
        'state_id',
        'state',
        'files',
        'address',
        'addresses',
        'deleted_at'
    ];
    protected $guarded = [
        'id',
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'state_id' => 'integer',
        'address_id' => 'integer',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function state() {
        return $this->belongsTo('App\UserGlobalModelState', 'state_id');
    }

    public function files() {
        return $this->hasMany('App\UserFile', 'user_global_model_id');
    }

    public function addresses() {
        return $this->hasMany('App\Address', 'user_global_model_id');
    }

    public function address() {
        return $this->belongsTo('App\Address', 'address_id');
    }

    public function submitable() {
        return (
            (
                isset($this->email)
                && $this->email !== ''
                && $this->email !== null
            ) && (
                isset($this->password)
                && $this->password !== ''
                && $this->password !== null
            ) && (
                isset($this->username)
                && $this->username !== ''
                && $this->username !== null
            ) && (
                isset($this->first_name)
                && $this->first_name !== ''
                && $this->first_name !== null
            ) && (
                isset($this->last_name)
                && $this->last_name !== ''
                && $this->last_name !== null
            ) && (
                isset($this->phone)
                && $this->phone !== ''
                && $this->phone !== null
            ) && (
                isset($this->address_id)
                && $this->address_id !== 0
                && $this->address_id !== null
            ));
    }
}
