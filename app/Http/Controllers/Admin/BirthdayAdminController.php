<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;
use App\Models\Member;

class BirthdayAdminController extends Controller
{
    public function seeAllBirthdays()
{
    $adminId = Session::get('admin_id');
    $today = Carbon::now();

    // Get all members in one query
    $members = Member::where('adminId', '=', $adminId)->get();

    // Filter today's birthdays
    $birthDays = $members->filter(function ($member) use ($today) {
        if (!isset($member['DOB']) || !is_numeric($member['DOB'])) {
            return false;
        }
        
        $dobStr = strval($member['DOB']); // Convert to string
        $dobMonth = substr($dobStr, 4, 2); // Extract MM
        $dobDay = substr($dobStr, 6, 2); // Extract DD

        return $dobMonth == $today->format('m') && $dobDay == $today->format('d');
    });

    // Define upcoming range
    $startRange = $today->copy()->addDay(); // Start from tomorrow
    $endRange = $startRange->copy()->addDays(5); // End 5 days from tomorrow

    // Filter upcoming birthdays
    $upcomingBirthdays = $members->filter(function ($member) use ($startRange, $endRange) {
        if (!isset($member['DOB']) || !is_numeric($member['DOB'])) {
            return false;
        }

        $dobStr = strval($member['DOB']); // Convert to string
        $dobMonth = substr($dobStr, 4, 2);
        $dobDay = substr($dobStr, 6, 2);

        $birthdayThisYear = Carbon::createFromDate(date('Y'), $dobMonth, $dobDay);

        return $birthdayThisYear->between($startRange, $endRange);
    });

    // Sort upcoming birthdays properly by month and day
    $upcomingBirthdays = $upcomingBirthdays->sortBy(function ($member) {
        $dobStr = strval($member['DOB']); // Convert to string
        $dobMonth = substr($dobStr, 4, 2);
        $dobDay = substr($dobStr, 6, 2);
        
        return Carbon::createFromDate(date('Y'), $dobMonth, $dobDay)->timestamp;
    });

    return view('admin.seeAllBirthdays', compact('birthDays', 'upcomingBirthdays'));
}

    /**
     * Parse the DOB field into a Carbon date, accommodating various formats.
     */
    private function parseDOB($dob)
    {
        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
                // Format: YYYY-MM-DD
                return Carbon::createFromFormat('Y-m-d', $dob);
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
                // Format: MM/DD/YYYY
                return Carbon::createFromFormat('m/d/Y', $dob);
            }
        } catch (\Exception $e) {
            // Invalid date format
        }
        return null;
    }


}
