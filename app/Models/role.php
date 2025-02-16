<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
