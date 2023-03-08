<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Fixed_key;

class Fixed_transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'amount',  
        'schedule',
        'is_paid',
        'next_payment_date',
        'fixed_key_id',
        'category_id',
        'currency_id',
    ];
    // public function category(){
    //     return $this->belongsTo(Category::class);
    // }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    // public function fixedkey(){
    //     return $this->belongsTo(Fixed_key::class);

    // }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function fixed_key(){
        return $this->belongsTo(Fixed_key::class);
    }
    
}
