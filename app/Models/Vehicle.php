<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'model',
        'no_plate',
        'no_seats',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_vehicle');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

}
