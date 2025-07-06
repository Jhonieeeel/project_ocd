<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'barcode',
        'item_price',
        'item_quantity',
        'remarks',
        'expiration',
        'supply_id'
    ];

    public function supply() {
        return $this->belongsTo(Supply::class);
    }

    public function withdraw() {
        return $this->hasMany(Withdraw::class);
    }
}
