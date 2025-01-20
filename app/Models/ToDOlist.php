<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDOlist extends Model
{
    use HasFactory;
    public $fillable = ['title', 'description', 'completed'];
    protected $primaryKey = 'id';
    protected $table = 'to_dos';
    // public $timestamps = false;
}
