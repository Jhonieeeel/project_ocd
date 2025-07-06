<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'requested_quantity',
        'stock_id',
        'user_id',
    ];

    public function withdraw() {
        return $this->hasMany(Withdraw::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function stock() {
        return $this->belongsTo(Stock::class);
    }
}
