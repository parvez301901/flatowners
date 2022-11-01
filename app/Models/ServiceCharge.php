<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ServiceCharge extends Model
{
    public function get_user() {
        return $this->belongsTo(User::class,'flatownerId','id');
    }
}
