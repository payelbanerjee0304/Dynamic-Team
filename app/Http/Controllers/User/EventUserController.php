<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

use MongoDB\BSON\ObjectId;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Admin;
use App\Models\Member;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class EventUserController extends Controller
{
    public function allEvents()
    {
        $userId = Session::get('user_id');

        $membershipType= Member::where('_id', '=', $userId)->value('Members_Type');
        $today = (int)(Carbon::now()->format('Ymd'));

        $events = Event::where('isDeleted', '!=', true)
        ->where('endDate','>', $today)
                        ->where(function ($query) use ($membershipType) {
                            $query->where('allowedVistors', 'All')
                                ->orWhere('allowedVistors', $membershipType);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('user.allEvents', compact('events'));
    }

    public function markInterested($eventId)
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'User not logged in']);
        }

        // Find the event
        $event = Event::where('_id', $eventId)->first();

        if (!$event) {
            return response()->json(['status' => 'error', 'message' => 'Event not found']);
        }

        // Check if user is already interested
        if (in_array($userId, $event->interestedMembers ?? [])) {
            return response()->json(['status' => 'error', 'message' => 'You have already shown interest!']);
        }

        // Push the user ID into interestedMembers array in MongoDB
        Event::where('_id', $eventId)->push('interestedMembers', $userId, true);

        return response()->json(['status' => 'success', 'message' => 'Interest added successfully!']);
    }


}
