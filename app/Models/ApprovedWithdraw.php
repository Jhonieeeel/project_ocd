<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovedWithdraw extends Model
{
    protected $fillable = ['withdraw_id', 'printed_times'];

    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class);
    }
}
