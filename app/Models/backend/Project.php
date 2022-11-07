<?php

namespace App\Models\backend;

use App\Models\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function get_utility_name(){
        return $this->belongsTo(Utility::class,'utility_id','id');
    }
}
