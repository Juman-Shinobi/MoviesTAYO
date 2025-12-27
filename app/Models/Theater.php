<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = [
        'theater_name',
        'location',
        'capacity',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
