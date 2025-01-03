<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Admin;
use App\Models\Member;

class BirthdayAdminController extends Controller
{
    public function seeAllBirthdays()
    {
        $today = Carbon::now();
        $todayDay = $today->format('d');
        $todayMonth = $today->format('m');

        // Filter today's birthdays
        $birthDays = Member::get()->filter(function ($member) use ($todayDay, $todayMonth) {
            if (isset($member['DOB'])) {
                $dob = $member['DOB'];
                $date = $this->parseDOB($dob);
                return $date && $date->format('d') == $todayDay && $date->format('m') == $todayMonth;
            }
            return false;
        });

        $birthDaysCount = $birthDays->count();

        $startRange = $today->copy()->addDay(); // Start from tomorrow
        $endRange = $startRange->copy()->addDays(5); // End 5 days from tomorrow

        // Filter upcoming birthdays
        $upcomingBirthdays = Member::get()->filter(function ($member) use ($startRange, $endRange) {
            if (isset($member['DOB'])) {
                $dob = $member['DOB'];
                $date = $this->parseDOB($dob);

                if ($date) {
                    // Create a Carbon date for the birthday this year
                    $birthdayThisYear = Carbon::createFromDate(date('Y'), $date->month, $date->day);

                    // Check if the birthday falls within the range
                    return $birthdayThisYear->between($startRange, $endRange);
                }
            }
            return false;
        });

        // Sort upcoming birthdays by date
        $upcomingBirthdays = $upcomingBirthdays->sortBy(function ($member) {
            $dob = $member['DOB'];
            $date = $this->parseDOB($dob);
            return $date ? $date->format('m-d') : null;
        });

        return view('admin.seeAllBirthdays', compact('birthDays', 'upcomingBirthdays'));
    }

    /**
     * Parse the DOB field into a Carbon date, accommodating various formats.
     */
    // private function parseDOB($dob)
    // {
    //     try {
    //         if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    //             // Format: YYYY-MM-DD
    //             return Carbon::createFromFormat('Y-m-d', $dob);
    //         } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
    //             // Format: MM/DD/YYYY
    //             return Carbon::createFromFormat('m/d/Y', $dob);
    //         }
    //     } catch (\Exception $e) {
    //         // Invalid date format
    //     }
    //     return null;
    // }
    private function parseDOB($dob)
    {
        try {
            // Check if the DOB is an instance of MongoDB\BSON\UTCDateTime
            if ($dob instanceof \MongoDB\BSON\UTCDateTime) {
                // Convert BSON UTCDateTime to a Carbon instance
                return Carbon::createFromTimestamp($dob->toDateTime()->getTimestamp());
            }
            
            // If DOB is in 'YYYY-MM-DD' format
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
                return Carbon::createFromFormat('Y-m-d', $dob);
            }

            // If DOB is in 'MM/DD/YYYY' format
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
                return Carbon::createFromFormat('m/d/Y', $dob);
            }

        } catch (\Exception $e) {
            // Invalid date format handling
        }

        return null;
    }


}
