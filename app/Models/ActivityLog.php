<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';
    // Fields that are allowed to be mass-assigned
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',  // Add this line to allow IP address to be mass-assigned
        'created_at',
        'updated_at',
    ];
    protected $dates = ['created_at', 'updated_at'];
    
    // Optionally, add a method to create logs more easily
    public static function createLog($user_id, $action, $description, $ip_address)
    {
        return self::create([
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip_address,  // Add the IP address to the log
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
