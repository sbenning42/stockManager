<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    static public $PARTNER = 1;
    static public $SPONSOR = 2;
    static public $PRENIUM = 3;
    static public $NONE = 4;

    static public $NONE_N = 'none';
    static public $PARTNER_N = 'partner';
    static public $SPONSOR_N = 'sponsor';
    static public $PRENIUM_N = 'prenium';

    protected $fillable = ['name'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];

    protected $casts = ['id' => 'integer'];

    static public function exists($id) {
        return ($id > 0 && $id <= self::$NONE);
    }

    public function users() {
        return $this->hasMany('App\Users', 'user_id');
    }
}
