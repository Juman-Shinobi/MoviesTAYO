<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'theater_id',
        'seat_number',
        'seat_status',
    ];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
