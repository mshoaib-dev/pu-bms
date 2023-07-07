<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'file_upload',
        'account_title',
        'account_number',
//        'status',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
