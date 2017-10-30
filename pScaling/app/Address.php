<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_global_model_id',
        'country_id',
        'name',
        'first_name',
        'last_name',
        'phone',
        'address',
        'complement',
        'floor',
        'elevator',
        'city',
        'postcode',
        'longitude',
        'latitude',
    ];
    protected $hidden = [
        'user_global_model_id'
    ];
    protected $guarded = [
    ];

    protected $casts = [
        'id' => 'integer',
        'user_global_model_id' => 'integer',
        'country_id' => 'integer',
        'floor' => 'integer',
        'elevator' => 'integer',
        'longitude' => 'integer',
        'latitude' => 'integer',
    ];

    public function userGlobalModel() {
        return $this->belongsTo('App\UserGlobalModel', 'user_global_model_id');
    }

    public function country() {
        return $this->belongsTo('App\Country', 'country_id');
    }
}
