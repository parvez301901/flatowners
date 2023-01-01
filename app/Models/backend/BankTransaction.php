<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model {

    public function get_bank_name() {
        return $this->belongsTo(Bank::class,'id','bank_id');
    }

}
