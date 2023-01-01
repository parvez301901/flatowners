<?php

namespace App\Models\backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAddAmount extends Model
{
    use HasFactory;

    public function get_user_name(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
