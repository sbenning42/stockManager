<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];

    protected $casts = ['id' => 'integer'];

    public function addresses() {
        return $this->hasMany('App\Address', 'country_id');
    }
}
