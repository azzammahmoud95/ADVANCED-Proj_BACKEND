<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'schedule',  
        
    ];
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    
}
