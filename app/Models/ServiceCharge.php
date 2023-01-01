<?php

namespace App\Models;

use App\Models\backend\Floor;
use App\Models\backend\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ServiceCharge extends Model
{
    /**
     * @var mixed|string
     */
    private $serviceChargeMonthYear;

    public function get_user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function get_floor() {
        return $this->belongsTo(Floor::class,'floor_id','id');
    }
    public function get_unit() {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }


}
