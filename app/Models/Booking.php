<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'start_date',
        'end_date',
        'departure_address',
        'destination_address',
        'phone_no',
        'cnic',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {

        return $this->hasMany(Payment::class);
    }
}
