<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

use MongoDB\BSON\ObjectId;
use Illuminate\Pagination\LengthAwarePaginator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Admin;
use App\Models\Member;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class EventAdminController extends Controller
{
    public function eventCreate()
    {
        return view('admin.eventCreate');
    }

    public function insertEvent(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $adminId = Session::get('admin_id');

        $formData = $request->all();

        $title=$formData['title'];
        $description=$formData['description'];
        $startDate=!empty($formData['startDate']) ? (int)(Carbon::createFromFormat('Y-m-d', $formData['startDate'])->format('Ymd')) : null;
        $startTime=$formData['startTime'];
        $endDate=!empty($formData['endDate']) ? (int)(Carbon::createFromFormat('Y-m-d', $formData['endDate'])->format('Ymd')) : null;
        $endTime=$formData['endTime'];
        $allowedVistors=$formData['allowedVistors'];

        $s3BucketFolder = 'southjstimages';
        $bannerPath = null;
        $eventImagesPaths = [];

        if ($request->hasFile('bannerImage')) {
            $bannerImage = $request->file('bannerImage');
            $bannerName = time() . '_' . $bannerImage->getClientOriginalName();
            $bannerPath = Storage::disk('s3')->putFileAs($s3BucketFolder, $bannerImage, $bannerName);
        }

        if ($request->hasFile('eventImages')) {
            $eventImagesPaths = [];
    
            foreach ($request->file('eventImages') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $filePath = Storage::disk('s3')->putFileAs($s3BucketFolder, $file, $imageName);
                $filePathUrl= Storage::disk('s3')->url($filePath);
                $eventImagesPaths[] = $filePathUrl; 
            }
        }

        $event = new Event;
        $event->title = $title;
        $event->description = $description;
        $event->startDate = $startDate;
        $event->startTime = $startTime;
        $event->endDate = $endDate;
        $event->endTime = $endTime;
        $event->bannerImage = $bannerPath ? Storage::disk('s3')->url($bannerPath) : null;
        $event->eventImages = $eventImagesPaths;
        $event->allowedVistors = $allowedVistors;
        $event->adminId = $adminId;
        $event->save();

        return redirect()->route('admin.eventListing')->with('success', 'Event inserted successfully.');
    }

    public function eventListing()
    {
        $adminId = Session::get('admin_id');

        $allEvent = Event::where('adminId',$adminId)->where('isDeleted', '!=', true)->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.eventListing', compact('allEvent'));
    }

    public function editEvent($eventId)
    {
        $adminId = Session::get('admin_id');
        $event= Event::find($eventId);

        return view('admin.eventEdit', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $adminId = Session::get('admin_id');

        // Update event details
        $event->title = $request->title;
        $event->description = $request->description;
        $event->startDate = !empty($request->startDate) ? (int)(Carbon::createFromFormat('Y-m-d', $request->startDate)->format('Ymd')) : null;
        $event->startTime = $request->startTime;
        $event->endDate = !empty($request->endDate) ? (int)(Carbon::createFromFormat('Y-m-d', $request->endDate)->format('Ymd')) : null;
        $event->endTime = $request->endTime;

        // Handle deleted images
        $deletedImages = json_decode($request->deletedImages, true) ?? [];
        if (!empty($deletedImages)) {
            foreach ($deletedImages as $imgUrl) {
                if (!empty($imgUrl)) {
                    $imagePath = parse_url($imgUrl, PHP_URL_PATH);
                    $imagePath = ltrim($imagePath, '/');
                    if (!empty($imagePath)) {
                        Storage::disk('s3')->delete($imagePath);
                    }
                }
            }
            // Remove deleted images from eventImages array
            $updatedImages = array_values(array_diff($event->eventImages ?? [], $deletedImages));
        } else {
            $updatedImages = $event->eventImages ?? [];
        }

        // Handle new images upload
        if ($request->hasFile('eventImages')) {
            foreach ($request->file('eventImages') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $filePath = Storage::disk('s3')->putFileAs('southjstimages', $file, $imageName);
                $updatedImages[] = Storage::disk('s3')->url($filePath);
            }
        }

        // Assign updated images manually
        $event->eventImages = $updatedImages;

        // Handle bannerImage (either a file or a URL)
        if ($request->hasFile('bannerImage')) {
            // If it's a file, upload it to S3
            $bannerFile = $request->file('bannerImage');
            $bannerName = time() . '_' . $bannerFile->getClientOriginalName();
            $bannerPath = Storage::disk('s3')->putFileAs('southjstimages', $bannerFile, $bannerName);
            $event->bannerImage = Storage::disk('s3')->url($bannerPath);
        } elseif ($request->filled('bannerImage') && filter_var($request->bannerImage, FILTER_VALIDATE_URL)) {
            // If it's a valid URL, just store it as text
            $event->bannerImage = $request->bannerImage;
        } else {
            // If no new banner image is uploaded and it's not a valid URL, set it to null
            $event->bannerImage = null;
        }

        $event->adminId = $adminId;
        $event->save();

        return redirect()->route('admin.eventListing')->with('success', 'Event updated successfully.');
    }

    public function deleteEvent(Request $request)
    {
        $adminId = Session::get('admin_id');

        $event = Event::where('adminId','=',$adminId)->find($request->id);
        if ($event) {
            // $event->delete();
            $event->isDeleted = true;
            $event->save();
            return response()->json(['success' => 'Event deleted successfully.']);
        } else {
            return response()->json(['error' => 'Event not found.'], 404);
        }
    }

    public function eventDetails($eventId)
    {
        $adminId = Session::get('admin_id');
        
        $currentDate = (int) Carbon::now()->format('Ymd');
        $event = Event::where('adminId','=',$adminId)->where(['_id' => $eventId])->first();

        return view('admin.eventDetails',  compact('event'));
    }

    public function interestedMembers($eventId)
    {
        $event= Event::find($eventId);
        
        $interestedMembers = collect($event->interestedMembers ?? []);
        $members = Member::whereIn('_id', $interestedMembers)->paginate(20); 

        return view('admin.eventMemberDetails', compact('event', 'members'));
    }

}
