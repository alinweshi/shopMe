<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $fillable = ['title', 'description', 'completed'];
    protected $primaryKey = 'id';
    public function scopeSearch($query, $term)
    {
        $term = "%{$term}%";
        return $query->where('title', 'like', $term); // For User model
        // return $query->where('title', 'like', $term); // For Task model
    }
}
