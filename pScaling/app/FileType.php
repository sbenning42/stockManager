<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    static public $PICTURE = 1;
    static public $DOC = 2;
    static public $RAW = 3;
    static public $NONE = 4;
    
    static public $NONE_N = 'none';
    static public $PICTURE_N = 'picture';
    static public $DOC_N = 'doc';
    static public $RAW_N = 'raw';
    
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

    public function userFiles() {
        return $this->hasMany('App\UserFile', 'type_id');
    }
}
