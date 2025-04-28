<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Mail\SubscriptionExpirationMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'national_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image',
        'status',
        'subscription_end_date',
    ];

    // Accessor for full_name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Accessor for subscription_end_date
    public function getSubscriptionEndDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d'); // Format the date as needed
    }

    // Mutator for email
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // Mutator for first_name
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    // Mutator for last_name
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    // Mutator for status
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value) === 'active' ? 'active' : 'inactive';
    }

    // Query scope for active customers
    public function scopeActive($query, $value = 'active')
    {
        return $query->where('status', $value);
    }

    // Query scope for customers whose subscription has ended
    public function scopeSubscriptionEndDate($query)
    {
        return $query->where('subscription_end_date', '<', now());
    }
    public function sendSubscriptionExpirationEmail($subscriptionEndDate)
    {
        // Logic to send the email
        \Mail::to($this->email)->send(new SubscriptionExpirationMail($this, $subscriptionEndDate));
    }
}
