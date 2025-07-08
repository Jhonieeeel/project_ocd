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
        'status',
        'stock_id',
        'user_id',
    ];
    public function approvedWithdraw()
    {
        return $this->hasMany(ApprovedWithdraw::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
