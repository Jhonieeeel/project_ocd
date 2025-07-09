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

    protected $casts = [
        'requested_by' => 'integer',
        'approved_by'  => 'integer',
        'issued_by'    => 'integer',
        'received_by'  => 'integer',
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


    // mutator
    public function setRequestedByAttribute($attributeValue) {
        $this->attributes['requested_by'] = $attributeValue;

        if($attributeValue) {
            $this->attributes['requested_date'] = now()->toDateString();
        }
    }

    public function setApprovedByAttribute($attributeValue) {
        $this->attributes['approved_by'] = $attributeValue;

        if($attributeValue) {
            $this->attributes['approved_date'] = now()->toDateString();
        }
    }

    public function setIssuedByAttribute($attributeValue) {
        $this->attributes['issued_by'] = $attributeValue;

        if ($attributeValue) {
            $this->attributes['issued_date'] = now()->toDateString();
        }
    }

    public function setUserIdAttribute($attributeValue)
    {
        $this->attributes['user_id'] = $attributeValue;

        // Optional: remove this if using saving() instead
        if (!is_null($attributeValue)) {
            $this->attributes['requested_by'] = $attributeValue;
        }
    }

    public function setReceivedByAttribute($attributeValue) {
        $this->attributes['received_by'] = $attributeValue;

        if ($attributeValue) {
            $this->attributes['received_date'] = now()->toDateString();
        }
    }
    
}
