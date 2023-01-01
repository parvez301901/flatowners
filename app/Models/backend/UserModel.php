<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public function get_floor_name(){
        return $this->belongsTo(Floor::class,'floorId','id');
    }
    public function get_floor_name_for_user(){
        return $this->belongsTo(Floor::class,'floor','id');
    }
    public function get_unit_name(){
        return $this->belongsTo(Unit::class,'unit','id');
    }

}
