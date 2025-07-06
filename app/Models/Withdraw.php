<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'ris',
        'requested_quantity',
        'requested_by',
        'approved_by',
        'issued_by',
        'received_by',
        'stock_id'
    ];

    public function stock() {
        return $this->belongsTo(Stock::class);
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function requestedBy(){
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function issuedBy() {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function receivedBy() {
        return $this->belongsTo(User::class, 'received_by');
    }
}
