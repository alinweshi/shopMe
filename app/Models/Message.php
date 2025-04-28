<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Timestamp;
    protected $fillable = ['id', 'sender_id', 'receiver_id', 'content', 'created_at', 'is_read'];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
