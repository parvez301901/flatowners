<?php

namespace App\Models\backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function get_floor_name(){
        return $this->belongsTo(Floor::class,'floor_id','id');
    }
    public function get_floor_name_for_user(){
        return $this->belongsTo(Floor::class,'floor','id');
    }
    public function get_unit_name(){
        return $this->belongsTo(Unit::class,'unit','id');
    }
    public function get_user_name(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function Floor(){
        return $this->belongsTo(Floor::class);
    }

    public function getServiceCharge() {
        //return $this->
    }

}
