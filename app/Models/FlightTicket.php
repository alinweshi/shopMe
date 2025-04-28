<?php

namespace App\Models;

use App\Models\Booking;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightTicket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = ['id', "title", "description", "price", "date", "stock"];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime',
        'price' => 'float'
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
