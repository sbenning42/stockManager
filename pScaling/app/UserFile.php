<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = [
        'name',
        'absolute',
        'http',
        'ftp',
    ];
    protected $hidden = [
        'user_global_model_id',
        'type_id'
    ];
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_global_model_id' => 'integer',
        'type_id' => 'integer',
    ];

    public function userGlobalModel() {
        return $this->belongsTo('App\UserGlobalModel', 'user_global_model_id');
    }

    public function type() {
        return $this->belongsTo('App\FileType', 'type_id');
    }
}
