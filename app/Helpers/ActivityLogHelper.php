<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogHelper
{
    public static function log($userId, $action, $description)
    {
        // Get the user's IP address from the request
        $ipAddress = request()->ip();

        ActivityLog::createLog($userId, $action, $description, $ipAddress);
    }
}