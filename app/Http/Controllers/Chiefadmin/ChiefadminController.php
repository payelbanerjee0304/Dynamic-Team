<?php

namespace App\Http\Controllers\Chiefadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use MongoDB\BSON\ObjectId;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Admin;
use App\Models\Chiefadmin;
use App\Models\Member;
use App\Models\MemberTest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ChiefadminController extends Controller
{
    public function login()
    {
        return view('chiefadmin/login');
    }

    public function save(Request $request)
    {
        $mobile = $request->input('mobile');
        // print_r($mobile);die;
        $mobileInt = (int) $mobile;
        $chiefadmin = Chiefadmin::where('phoneNumber', '=', $mobile)->get();
        // echo "<pre>";
        // print_r($admin);
        // die;

        if (empty($chiefadmin[0])) {
            return response()->json(['status' => 'error', 'message' => 'Chief Admin not found']);
        } else {
            $otp = rand(100000, 999999);
            $var = ['otp' => $otp];
            Chiefadmin::where('phoneNumber', '=', $mobile)->update($var);
            $getDataOtp = Chiefadmin::where('phoneNumber', '=', $mobile)->get();
            return response($getDataOtp);
        }
    }
    public function verifyAndLogin(Request $request)
    {
        $mobile = $request->input('mobile');
        $mobileInt = (int) $mobile;
        $otp = $request->input('otp');
        $chiefadmin = Chiefadmin::where('phoneNumber', '=', $mobile)->get();
        if (empty($otp)) {
            return response()->json(['status' => 'error', 'message' => 'Please Enter Your One Time Password'], 404);
        } else if ($chiefadmin[0]['otp'] != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Wrong OTP'], 404);
        } else {
            Session::put('chiefadmin', $chiefadmin);
            session(['chief_admin_id' => $chiefadmin[0]['_id']]);
            if (Session::has('chief_admin_id')) {
                $userId = Session::get('chief_admin_id');
                return response()->json(['status' => 'success', 'chiefadmin' => $chiefadmin]);
            } else {
                echo "Chief Admin ID session variable not set";
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('chief_admin_id');
        return redirect('chiefadmin/login')->with('message', 'Logout successfully');
    }

    public function dashboard()
    {
        // echo "Coming Soon...";die;

        $organizers= Admin::where('isDeleted','!=',true)->paginate(20);
        return view('chiefadmin/dashboard',compact('organizers'));
    }

    public function paginateDashboard()
    {
        $organizers= Admin::where('isDeleted','!=',true)->paginate(20);
        return view('chiefadmin/dashboard_pagination',compact('organizers'));
    }

    public function searchDashboard(Request $request)
    {
        $keyword = $request->input('keyword');
        $organizers = Admin::where('name', 'LIKE', "{$keyword}%")
            ->orWhere('phoneNumber', 'LIKE', "{$keyword}%")
            ->where('isDeleted', '!=', true)
            // ->orderBy('name', 'asc')
            ->paginate(20);

        return view('chiefadmin.dashboard_search', compact('organizers'))->render();
    }

    public function addOrganizer()
    {
        return view('chiefadmin.addOrganizer');
    }

    public function insertOrganizer(Request $request)
    {
        // echo "hi";die;
        $formData = $request->all();
        // echo "<pre>";
        // print_r($request->logoImage);die;

        $organizers= new Admin;

        $organizers->name= $formData['name']?? "";
        $organizers->emailId= $formData['email']?? "";
        $organizers->phoneNumber= $formData['phone']?? "";
        $organizers->address= $formData['address']?? "";

        if ($request->file('logoImage')) 
        {
            // echo "hi";
            $file = $request->file('logoImage');
            $filename = time() . "_" . $file->getClientOriginalName();

            $uploadLocation = public_path('upload');
            $fileSize = $file->getSize();

            if ($fileSize > 4 * 1024 * 1024) 
            { 
                $image = Image::make($file);
                $image->save($uploadLocation . '/' . $filename, 75); // Compress the image to 75% quality
            } else 
            {
                // If the file is smaller than or equal to 4MB, move it without compression
                $file->move($uploadLocation, $filename);
            }

            $localFilePath = $uploadLocation . '/' . $filename;

            $s3BucketFolder = 'southjstimages';
            $s3FilePath = $s3BucketFolder . '/' . $filename;
            Storage::disk('s3')->put($s3FilePath, file_get_contents($localFilePath));
            $fileLink = Storage::disk('s3')->url($s3FilePath);
            $organizers->headerLogo = $fileLink;


            if (file_exists($localFilePath)) {
                unlink($localFilePath);
            }
        }
        // die;

        $organizers->save();


        return redirect('/chiefadmin/dashboard')->with('success', 'Organization information inserted successfully.');
    }

    public function editOrganizer($id)
    {
        $organizers = Admin::where('_id', $id)->first();


        return view('chiefadmin.editOrganizer', compact('organizers'));
    }

    public function updateOrganizer(Request $request)
    {
        $organizerId = $request->input('organizerId'); // Get memberId from the form data

        if ($organizerId) {
            // Assuming you have a Member model, retrieve the member and update their information
            $organizers = Admin::find($organizerId);
            // echo "$organizers";
            if ($organizers) {
                $formData = $request->all();

                $organizers->name = $formData['name'] ?? "";
                $organizers->emailId = $formData['email'] ?? "";
                $organizers->phoneNumber = $formData['phone'] ?? "";
                $organizers->address = $formData['address'] ?? "";
                if ($request->file('logoImage')) 
                {
                    $file = $request->file('logoImage');
                    $filename = time() . "_" . $file->getClientOriginalName();

                    $uploadLocation = public_path('upload');
                    $fileSize = $file->getSize();

                    if ($fileSize > 4 * 1024 * 1024) 
                    { 
                        $image = Image::make($file);
                        $image->save($uploadLocation . '/' . $filename, 75); // Compress the image to 75% quality
                    } else 
                    {
                        // If the file is smaller than or equal to 4MB, move it without compression
                        $file->move($uploadLocation, $filename);
                    }

                    $localFilePath = $uploadLocation . '/' . $filename;

                    $s3BucketFolder = 'southjstimages';
                    $s3FilePath = $s3BucketFolder . '/' . $filename;
                    Storage::disk('s3')->put($s3FilePath, file_get_contents($localFilePath));
                    $fileLink = Storage::disk('s3')->url($s3FilePath);
                    $organizers->headerLogo = $fileLink;


                    if (file_exists($localFilePath)) 
                    {
                        unlink($localFilePath);
                    }
                }
                $organizers->save();
                return redirect('/chiefadmin/dashboard')->with('success', 'Organization information inserted successfully.');
            }else {
                return redirect()->back()->with('error', 'Organizer not found.');
            }
        }else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function deleteOrganizer(Request $request)
    {
        $organizerId = Admin::find($request->id);
        // print_r($organizerId);die;
        if ($organizerId) 
        {
            $organizerId->isDeleted = true;
            $organizerId->save();
            return response()->json(['success' => 'Organizer deleted successfully.']);
        } 
        else 
        {
            return response()->json(['error' => 'Organizer not found.'], 404);
        }
    }

}
