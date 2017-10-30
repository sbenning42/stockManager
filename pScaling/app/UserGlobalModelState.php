<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGlobalModelState extends Model
{
    static public $CREATED = 1;
    static public $SUBMITED = 2;
    static public $VALIDATED = 3;
    static public $INCOMPLETE = 4;
    static public $INELIGIBLE = 5;
    static public $NONE = 6;
    
    static public $NONE_N = 'none';
    static public $CREATED_N = 'created';
    static public $SUBMITED_N = 'submited';
    static public $VALIDATED_N = 'validated';
    static public $INCOMPLETE_N = 'incomplete';
    static public $INELIGIBLE_N = 'ineligible';
    
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

    public function userGlobalModels() {
        return $this->hasMany('App\userGlobalModels', 'state_id');
    }
}
