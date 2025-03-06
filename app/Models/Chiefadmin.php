<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Chiefadmin extends Model
{
    // use HasFactory;
    use Notifiable;
    
    protected $connection = 'mongodb';
}
