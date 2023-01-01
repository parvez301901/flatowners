<?php

namespace App\Models\backend;

use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    use HasFactory;

    public function get_user_name(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function get_project_name(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function get_utility_name(){
        return $this->belongsTo(Utility::class,'utility_id','id');
    }
}
