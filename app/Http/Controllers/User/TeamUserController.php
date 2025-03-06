<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\MemberHistory;

class TeamUserController extends Controller
{
    public function positionDetails()
    {
        $userId = Session::get('user_id');
        // Retrieve the first matching record based on memberId
        $member = MemberHistory::where('memberId', $userId)->first();
        $memberName= $member ? $member['memberName'] : null;
        

        $memberHistory = $member ? $member['history'] : [];
        // print_r($memberHistory);die;
        $filteredHistory = [];
        $today = date('Ymd'); 

        foreach ($memberHistory as $history) {
            if ($history['positionStartDate'] <= $today && $history['positionEndDate'] >= $today) {
                $filteredHistory[] = $history; 
            }
        }

        // Find the highest level (smallest value, e.g., L1 < L2)
        $highestLevel = null;
        if (!empty($filteredHistory)) {
            $highestLevel = min(array_column($filteredHistory, 'grouplevel'));
        }

        // Get all records matching the highest level
        $highestPositions = [];
        foreach ($filteredHistory as $history) {
            if ($history['grouplevel'] === $highestLevel) {
                $highestPositions[] = $history; // Collect all matching positions
            }
        }

        return view('user.userPosition',compact('memberName', 'memberHistory','highestPositions'));
    }
}
