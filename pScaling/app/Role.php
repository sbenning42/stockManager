<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    static public $USER = 1;
    static public $ADMIN = 2;
    static public $DEV = 3;
    static public $GOD = 4;
    static public $NONE = 5;
    
    static public $NONE_N = 'none';
    static public $USER_N = 'user';
    static public $ADMIN_N = 'admin';
    static public $DEV_N = 'dev';
    static public $GOD_N = 'god';
    
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
