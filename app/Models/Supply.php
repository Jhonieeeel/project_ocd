<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'item_description',
        'category',
        'unit',
        'image'
    ];
    
    public function stock() {
        return $this->hasMany(Stock::class);
    }
}
