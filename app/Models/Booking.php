<?php

namespace App\Models;

use App\Models\FlightTicket;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['id', 'ticket_id', 'user_id', 'quantity'];

    public function tickets()
    {
        return $this->hasMany(FlightTicket::class);
    }
}
