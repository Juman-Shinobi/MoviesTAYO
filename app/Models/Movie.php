<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'genre',
        'rating',
        'duration',
        'release_date',
        'description',
        'poster_path',
        'status',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
