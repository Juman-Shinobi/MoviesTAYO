<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'showtime_id',
        'user_id',
        'booking_date',
        'num_tickets',
        'movie_id',
        'seat_id',
        'booking_code',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats');
    }
}
