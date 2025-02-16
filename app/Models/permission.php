<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class permission extends Model
{
    use HasFactory, HasRelationships;
    protected $fillable = ['name', 'description', 'role_id'];
    // Relationships
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }
}
