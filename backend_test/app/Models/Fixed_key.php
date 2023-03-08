<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixed_key extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',  
        'is_active',
    ];
    public function fixedtrans(){
        return $this->hasMany(Fixed_transaction::class);
    }
}
