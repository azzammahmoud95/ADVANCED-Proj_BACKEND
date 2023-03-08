<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'name',  
        
    ];
    public function goal(){
        return $this->hasOne(Goal::class);
    }
    public function fixedtrans(){
        return $this->hasMany(Fixed_transaction::class);
    }
}
