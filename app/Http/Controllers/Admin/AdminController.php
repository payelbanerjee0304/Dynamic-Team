<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Admin;
use App\Models\Member;
use App\Models\MemberTest;
use App\Models\Event;
use App\Models\Team;
use App\Models\MemberHistory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }

    public function save(Request $request)
    {
        $mobile = $request->input('mobile');
        // print_r($mobile);die;
        $mobileInt = (int) $mobile;
        $admin = Admin::where('phoneNumber', '=', $mobile)->get();

        if (empty($admin[0])) {
            return response()->json(['status' => 'error', 'message' => 'Admin not found']);
        } else {
            $otp = rand(100000, 999999);
            $var = ['otp' => $otp];
            Admin::where('phoneNumber', '=', $mobile)->update($var);
            $getDataOtp = Admin::where('phoneNumber', '=', $mobile)->get();
            return response($getDataOtp);
        }
    }
    public function verifyAndLogin(Request $request)
    {
        $mobile = $request->input('mobile');
        $mobileInt = (int) $mobile;
        $otp = $request->input('otp');
        $admin = Admin::where('phoneNumber', '=', $mobile)->get();
        if (empty($otp)) {
            return response()->json(['status' => 'error', 'message' => 'Please Enter Your One Time Password'], 404);
        } else if ($admin[0]['otp'] != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Wrong OTP'], 404);
        } else {
            Session::put('admin', $admin);
            session(['admin_id' => $admin[0]['_id']]);
            if (Session::has('admin_id')) {
                $userId = Session::get('admin_id');
                return response()->json(['status' => 'success', 'admin' => $admin]);
            } else {
                echo "Admin ID session variable not set";
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        return redirect('admin/login')->with('message', 'Logout successfully');
    }

    public function view()
    {
        return view('admin.view');
    }

    public function addMember()
    {
        // echo "hi";die;
        return view('admin.addMember');
    }

    public function insertMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        $formData = $request->all();
        // echo "<pre>";
        // print_r($formData);die;

        $newMember = new Member();

        $newMember->Membership_No = $formData['Membership_No'] ?? "";
        $newMember->Members_Type = $formData['Members_Type'] ?? "";
        $newMember->Surname = $formData['Surname'] ?? "";
        $newMember->Name = $formData['Name'] ?? "";
        $newMember->Middle_Name = $formData['MidName'] ?? "";
        $newMember->Son_Daughter_of = $formData['Son_Daughter_of'] ?? "";
        $newMember->Spouse = $formData['Spouse'] ?? "";
        $newMember->gender = $formData['gender'] ?? "";
        $newMember->hasTerapanthCard = $formData['hasTerapanthCard'] ?? "";


        $newMember->DOB = (int) Carbon::createFromFormat('Y-m-d', $formData['DOB'])->format('Ymd') ?? "";
        $newMember->age = $formData['age'] ?? "";
        $newMember->DOM = $formData['DOM'] ?? "";
        $newMember->bloodGroup = $formData['bloodGroup'] ?? "";
        $newMember->Qualification = $formData['Qualification'] ?? "";
        $newMember->Occupation = $formData['Occupation'] ?? "";
        $newMember->Mobile = $formData['Mobile'] ?? "";
        $newMember->alternateNumber = $formData['alternateNumber'] ?? "";
        $newMember->Email_ID = $formData['Email_ID'] ?? "";
        $newMember->Residence1 = $formData['Residence1'] ?? "";
        $newMember->Residence2 = $formData['Residence2'] ?? "";
        $newMember->Residence3 = $formData['Residence3'] ?? "";
        $newMember->Residence4 = $formData['Residence4'] ?? "";
        $newMember->Res_PINCODE = $formData['Res_PINCODE'] ?? "";
        $newMember->Native_Place = $formData['Native_Place'] ?? "";
        $newMember->Phone = $formData['Phone'] ?? "";

        $newMember->familyMember1Name = $formData['familyMember1Name'] ?? "";
        $newMember->familyMember1Phone = $formData['familyMember1Phone'] ?? "";
        $newMember->familyMember1Relation = $formData['familyMember1Relation'] ?? "";
        $newMember->familyMember2Name = $formData['familyMember2Name'] ?? "";
        $newMember->familyMember2Phone = $formData['familyMember2Phone'] ?? "";
        $newMember->familyMember2Relation = $formData['familyMember2Relation'] ?? "";
        $newMember->familyMember3Name = $formData['familyMember3Name'] ?? "";
        $newMember->familyMember3Phone = $formData['familyMember3Phone'] ?? "";
        $newMember->familyMember3Relation = $formData['familyMember3Relation'] ?? "";
        $newMember->familyMember4Name = $formData['familyMember4Name'] ?? "";
        $newMember->familyMember4Phone = $formData['familyMember4Phone'] ?? "";
        $newMember->familyMember4Relation = $formData['familyMember4Relation'] ?? "";
        $newMember->familyMember5Name = $formData['familyMember5Name'] ?? "";
        $newMember->familyMember5Phone = $formData['familyMember5Phone'] ?? "";
        $newMember->familyMember5Relation = $formData['familyMember5Relation'] ?? "";
        $newMember->familyMember6Name = $formData['familyMember6Name'] ?? "";
        $newMember->familyMember6Phone = $formData['familyMember6Phone'] ?? "";
        $newMember->familyMember6Relation = $formData['familyMember6Relation'] ?? "";

        // $newMember->numOfFamilyMembers = $formData['familyDetails'];

        // $numOfFamilyMembers = (int) $formData['familyDetails'];
        // for ($i = 1; $i <= $numOfFamilyMembers; $i++) {
        //     $nameField = 'familyMember' . $i . 'Name';
        //     $phoneField = 'familyMember' . $i . 'Phone';

        //     if (isset($formData[$nameField]) && isset($formData[$phoneField])) {
        //         $newMember->{$nameField} = $formData[$nameField];
        //         $newMember->{$phoneField} = $formData[$phoneField];
        //     }
        // }

        $newMember->businessName = $formData['businessName'] ?? "";
        $newMember->{'Office-1'} = $formData['Office-1'] ?? "";
        $newMember->{'Office-2'} = $formData['Office-2'] ?? "";
        $newMember->{'Office-3'} = $formData['Office-3'] ?? "";
        $newMember->{'Office-4'} = $formData['Office-4'] ?? "";

        if ($request->file('image')) {

            $file = $request->file('image');
            $filename = time() . "_" . $file->getClientOriginalName();

            $uploadLocation = public_path('upload');
            $fileSize = $file->getSize();
            
            // $file->move($uploadLocation, $filename);
            // $image = Image::make($file);
            // $image->save($uploadLocation . '/' . $filename, 75);

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
            $newMember->image = $fileLink;


            if (file_exists($localFilePath)) {
                unlink($localFilePath);
            }
        }

        $newMember->PINCODE = $formData['PINCODE'] ?? "";
        $newMember->Deals_In = $formData['Deals_In'] ?? "";
        $newMember->Phone_O = $formData['Phone_O'] ?? "";
        $newMember->Mobile_O = $formData['Mobile_O'] ?? "";
        // $newMember->businessFaxNo = $formData['businessFaxNo'] ?? "";
        $newMember->Email_O = $formData['Email_O'] ?? "";
        $newMember->adminId = $adminId;

        $newMember->save();

        if ($newMember->save()) {
            ActivityLogHelper::log($adminId, 'Member Created', 'Member inserted by ID ' . (string) $adminId);
        }

        return redirect('/admin/view')->with('success', 'Member information inserted successfully.');
    }

    public function generatePdf(Request $request)
    {
        $adminId = Session::get('admin_id');

        // print_r("coming soon");die;
        // Retrieve the member ID from the request
        $memberId = $request->input('memberId');
        
        // Fetch the member from the database
        $member = Member::where('adminId','=',$adminId)->find($memberId);

        // Check if the member exists
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        // Prepare the data to be passed to the view
        $data = [
            'name' => $member->Name,
            'middle_name' => $member->Middle_Name,
            'surname' => $member->Surname,
            // 'mobile' => $member->Mobile,
            // 'membership_type' => $member->Members_Type,
        ];

        // Load the view and pass the data
        $pdf = PDF::loadView('pdf.memberDetails', $data);

        // Save the PDF to a specific location
        $fileName = 'member_' . $memberId . '.pdf';
        $localFilePath = storage_path('app/public/' . $fileName);
        $pdf->save($localFilePath);

        // Upload PDF to S3
        $s3BucketFolder = 'southjstimages';
        $s3FilePath = $s3BucketFolder . '/' . $fileName;
        Storage::disk('s3')->put($s3FilePath, file_get_contents($localFilePath));

        // Generate S3 public URL
        $fileLink = Storage::disk('s3')->url($s3FilePath);

        // Remove local file
        if (file_exists($localFilePath)) {
            unlink($localFilePath);
        }

        // Return a response with the PDF URL
        return response()->json([
            'success' => true,
            'pdf_url' => $fileLink,
        ]);
    }

    public function generateMemberPdf(Request $request)
    {
        $adminId = Session::get('admin_id');

        $memberId = $request->input('memberId');
        $member = Member::where('adminId','=',$adminId)->find($memberId);

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $data = [
            'Members_Type' => $member->Members_Type ?? '',
            'Membership_No' => $member->Membership_No ?? '',
            'Surname' => $member->Surname ?? '',
            'Name' => $member->Name ?? '',
            'Middle_Name' => $member->Middle_Name ?? '',
            'Son_Daughter_of' => $member->Son_Daughter_of ?? '',
            'Residence1' => $member->Residence1 ?? '',
            'Residence2' => $member->Residence2 ?? '',
            'Residence3' => $member->Residence3 ?? '',
            'Residence4' => $member->Residence4 ?? '',
            'Res_PINCODE' => $member->Res_PINCODE ?? '',
            'Phone' => $member->Phone ?? '',
            'Mobile' => $member->Mobile ?? '',
            'Email_ID' => $member->Email_ID ?? '',
            'Office_1' => $member->Office_1 ?? '',
            'Office_2' => $member->Office_2 ?? '',
            'Office_3' => $member->Office_3 ?? '',
            'Office_4' => $member->Office_4 ?? '',
            'PINCODE' => $member->PINCODE ?? '',
            'Phone_O' => $member->Phone_O ?? '',
            'Mobile_O' => $member->Mobile_O ?? '',
            'Email_ID_O' => $member->Email_ID_O ?? '',
            'Qualification' => $member->Qualification ?? '',
            'Occupation' => $member->Occupation ?? '',
            'Deals_In' => $member->Deals_In ?? '',
            'DOB' => $member->DOB ?? '',
            'DOM' => $member->DOM ?? '',
            'Spouse' => $member->Spouse ?? '',
            'Native_Place' => $member->Native_Place ?? '',
            'age' => $member->age ?? '',
            'alternateNumber' => $member->alternateNumber ?? '',
            'bloodGroup' => $member->bloodGroup ?? '',
            'businessFaxNo' => $member->businessFaxNo ?? '',
            'businessName' => $member->businessName ?? '',
            'familyDetails' => $member->familyDetails ?? '',
            'isVerified' => $member->isVerified ?? '',
            'image' => $member->image ?? '',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $data["familyMember{$i}Name"] = $member["familyMember{$i}Name"] ?? '';
            $data["familyMember{$i}Phone"] = $member["familyMember{$i}Phone"] ?? '';
            $data["familyMember{$i}Relation"] = $member["familyMember{$i}Relation"] ?? '';
        }

        $pdf = PDF::loadView('pdf.memberDetails', $data);

        return $pdf->download("member_{$memberId}.pdf");
    }

    public function allMembers(Request $request)
    {
        $adminId = Session::get('admin_id');

        $allCount = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)->count();
        $founderCount = Member::where('adminId','=',$adminId)->where('Members_Type', 'FOUNDER')->where('isDeleted', '!=', true)->count();
        $patronCount = Member::where('adminId','=',$adminId)->where('Members_Type', 'PATRON')->where('isDeleted', '!=', true)->count();
        $lifeCount = Member::where('adminId','=',$adminId)->where('Members_Type', 'LIFE')->where('isDeleted', '!=', true)->count();

        $verifiedCount = Member::where('adminId','=',$adminId)->where('isVerified', 'Yes')->where('isDeleted', '!=', true)->count();
        $reverifiedCount = Member::where('isVerified', 'reverified')->where('isDeleted', '!=', true)->count();

        $paginateInput = $request->input('paginateInput', 20);
        $members = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc')
            ->paginate($paginateInput);
        return view('admin.membersView', compact('members', 'paginateInput', 'allCount', 'founderCount', 'patronCount', 'lifeCount', 'verifiedCount','reverifiedCount'));
    }

    public function paginateMember(Request $request)
    {
        $adminId = Session::get('admin_id');

        $paginateInput = $request->input('paginateInput', 20);
        $members = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc')
            ->paginate($paginateInput);
        return view('admin.membersView_pagination', compact('members', 'paginateInput'));
    }

    public function searchMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        // echo "$adminId";die;

        $paginateInput = $request->input('paginateInput', 20);
        $keyword = $request->input('keyword');
        $members = Member::where('Name', 'LIKE', "{$keyword}%")
            ->orWhere('Surname', 'LIKE', "{$keyword}%")
            ->orWhere('Middle_Name', 'LIKE', "{$keyword}%")
            ->orWhereRaw([
                '$expr' => [
                    '$regexMatch' => [
                        'input' => ['$toString' => '$Mobile'], // Convert `Mobile` to string
                        'regex' => "^{$keyword}",
                        'options' => 'i'
                    ]
                ]
            ])
            ->where('isDeleted', '!=', true)
            ->where('adminId','=',$adminId)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc')
            ->paginate($paginateInput);

        return view('admin.membersView_search', compact('members', 'paginateInput'))->render();
    }

    public function suggestMembers(Request $request)
    {
        $adminId = Session::get('admin_id');

        $keyword = $request->input('keyword');

        // Retrieve members with full name, excluding deleted members, and matching the keyword
        $suggestions = Member::where('adminId','=',$adminId)->where(function ($query) use ($keyword) {
            $query->where('Name', 'LIKE', "{$keyword}%")
                ->orWhere('Surname', 'LIKE', "{$keyword}%")
                ->orWhere('Middle_Name', 'LIKE', "{$keyword}%")
                ->orWhereRaw([
                    '$expr' => [
                        '$regexMatch' => [
                            'input' => ['$toString' => '$Mobile'], // Convert `Mobile` to string
                            'regex' => "^{$keyword}",
                            'options' => 'i'
                        ]
                    ]
                ]);
        })
            ->where('isDeleted', '!=', true)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc')
            ->get(['Name', 'Middle_Name', 'Surname', '_id', 'Mobile']);

        // Create HTML for each suggestion with full names
        $output = '';
        $id = '';
        foreach ($suggestions as $suggestion) {
            // Construct full name format
            $fullName = trim($suggestion->Name . ' ' . $suggestion->Middle_Name . ' ' . $suggestion->Surname);
            $id = (string)$suggestion->_id;
            $mobile = $suggestion->Mobile;
            $output .= '<div data-id="' . e($id) . '" data-fullname="' . e($fullName) . '" data-mobile="' . e($mobile) . '">' . e($fullName) . ' (' . e($mobile) . ')</div>';
        }

        return response()->json($output);
    }

    public function searchKeywordMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        
        $paginateInput = $request->input('paginateInput', 20);
        $selectedId = $request->input('selectedId');
        // print_r($keyword);die;

        // $nameParts = explode(' ', trim($keyword));
        // $name = $nameParts[0] ?? '';            // First part as Name
        // $middleName = $nameParts[1] ?? '';       // Second part as Middle_Name (if available)
        // $surname = isset($nameParts[2]) ? implode(' ', array_slice($nameParts, 2)) : '';
        $members = Member::where('adminId','=',$adminId)->where('_id', $selectedId)
            //  ->where('Middle_Name', $middleName)
            //  ->where('Surname', $surname)
            ->where('isDeleted', '!=', true)
            ->paginate($paginateInput);

        return view('admin.membersView_search', compact('members', 'paginateInput'))->render();
    }


    public function filterMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        
        $membersType = $request->input('membersType', 'all');
        $paginateInput = $request->input('paginateInput', 20);
        $query = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc');

        if ($membersType !== 'all') {
            $query->where('Members_Type', $membersType);
        }

        $members = $query->paginate($paginateInput);
        return view('admin.membersView_search', compact('members', 'paginateInput'))->render();
    }
    
    public function editMember($id)
    {
        $adminId = Session::get('admin_id');

        $member = Member::where('adminId','=',$adminId)->where('_id', $id)->first();

        if (isset($member['DOB']) && $member['DOB'] != "") {
            $member['DOB'] = date('Y-m-d', strtotime($member['DOB']));
        }

        if (isset($member['DOM']) && $member['DOM'] != "") {

            $member['DOM'] = date('Y-m-d', strtotime($member['DOM']));
        }

        return view('admin.editMember', compact('member'));
    }

    public function updateMember(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $adminId = Session::get('admin_id');
        $memberId = $request->input('memberId'); // Get memberId from the form data

        if ($memberId) {
            // Assuming you have a Member model, retrieve the member and update their information
            $newMember = Member::where('adminId','=',$adminId)->find($memberId);
            // print_r($memberId);die;

            if ($newMember) {
                $formData = $request->all();
                // $newMember->Membership_No = $formData['Membership_No'] ?? "";
                // $newMember->Members_Type = $formData['Members_Type'] ?? "";
                $newMember->Surname = $formData['Surname'] ?? "";
                $newMember->Name = $formData['Name'] ?? "";
                $newMember->Middle_Name = $formData['MidName'] ?? "";
                $newMember->Son_Daughter_of = $formData['Son_Daughter_of'] ?? "";
                $newMember->Spouse = $formData['Spouse'] ?? "";
                $newMember->hasTerapanthCard = $formData['hasTerapanthCard'] ?? "";


                $newMember->DOB = (int) Carbon::createFromFormat('Y-m-d', $formData['DOB'])->format('Ymd') ?? "";
                $newMember->age = $formData['age'] ?? "";
                $newMember->DOM = $formData['DOM'] ?? "";
                $newMember->bloodGroup = $formData['bloodGroup'] ?? "";
                $newMember->Qualification = $formData['Qualification'] ?? "";
                $newMember->Occupation = $formData['Occupation'] ?? "";
                $newMember->Mobile = $formData['Mobile'] ?? "";
                $newMember->alternateNumber = $formData['alternateNumber'] ?? "";
                $newMember->Email_ID = $formData['Email_ID'] ?? "";
                $newMember->Residence1 = $formData['Residence1'] ?? "";
                $newMember->Residence2 = $formData['Residence2'] ?? "";
                $newMember->Residence3 = $formData['Residence3'] ?? "";
                $newMember->Residence4 = $formData['Residence4'] ?? "";
                $newMember->Res_PINCODE = $formData['Res_PINCODE'] ?? "";
                $newMember->Native_Place = $formData['Native_Place'] ?? "";
                $newMember->Phone = $formData['Phone'] ?? "";


                $newMember->familyMember1Name = $formData['familyMember1Name'] ?? "";
                $newMember->familyMember1Phone = $formData['familyMember1Phone'] ?? "";
                $newMember->familyMember1Relation = $formData['familyMember1Relation'] ?? "";
                $newMember->familyMember2Name = $formData['familyMember2Name'] ?? "";
                $newMember->familyMember2Phone = $formData['familyMember2Phone'] ?? "";
                $newMember->familyMember2Relation = $formData['familyMember2Relation'] ?? "";
                $newMember->familyMember3Name = $formData['familyMember3Name'] ?? "";
                $newMember->familyMember3Phone = $formData['familyMember3Phone'] ?? "";
                $newMember->familyMember3Relation = $formData['familyMember3Relation'] ?? "";
                $newMember->familyMember4Name = $formData['familyMember4Name'] ?? "";
                $newMember->familyMember4Phone = $formData['familyMember4Phone'] ?? "";
                $newMember->familyMember4Relation = $formData['familyMember4Relation'] ?? "";
                $newMember->familyMember5Name = $formData['familyMember5Name'] ?? "";
                $newMember->familyMember5Phone = $formData['familyMember5Phone'] ?? "";
                $newMember->familyMember5Relation = $formData['familyMember5Relation'] ?? "";
                $newMember->familyMember6Name = $formData['familyMember6Name'] ?? "";
                $newMember->familyMember6Phone = $formData['familyMember6Phone'] ?? "";
                $newMember->familyMember6Relation = $formData['familyMember6Relation'] ?? "";



                // $newMember->numOfFamilyMembers = $formData['familyDetails'];

                // $numOfFamilyMembers = (int) $formData['familyDetails'];
                // for ($i = 1; $i <= $numOfFamilyMembers; $i++) {
                //     $nameField = 'familyMember' . $i . 'Name';
                //     $phoneField = 'familyMember' . $i . 'Phone';
                //     $relationField = 'familyMember' . $i . 'Relation';

                //     if (isset($formData[$nameField]) && isset($formData[$phoneField])) {
                //         $newMember->{$nameField} = $formData[$nameField];
                //         $newMember->{$phoneField} = $formData[$phoneField];
                //         $newMember->{$relationField} = $formData[$relationField];
                //     }
                // }

                $newMember->businessName = $formData['businessName'] ?? "";
                $newMember->{'Office-1'} = $formData['Office-1'] ?? "";
                $newMember->{'Office-2'} = $formData['Office-2'] ?? "";
                $newMember->{'Office-3'} = $formData['Office-3'] ?? "";
                $newMember->{'Office-4'} = $formData['Office-4'] ?? "";

                if ($request->file('image')) {
                    $file = $request->file('image');
                    $filename = time() . "_" . $file->getClientOriginalName();

                    $uploadLocation = public_path('upload');
                    $fileSize = $file->getSize();
            
                    // $file->move($uploadLocation, $filename);
                    // $image = Image::make($file);
                    // $image->save($uploadLocation . '/' . $filename, 75);

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
                    $newMember->image = $fileLink;


                    if (file_exists($localFilePath)) {
                        unlink($localFilePath);
                    }
                }

                $newMember->PINCODE = $formData['PINCODE'] ?? "";
                $newMember->Deals_In = $formData['Deals_In'] ?? "";
                $newMember->Phone_O = $formData['Phone_O'] ?? "";
                $newMember->Mobile_O = $formData['Mobile_O'] ?? "";
                // $newMember->businessFaxNo = $formData['businessFaxNo'] ?? "";
                $newMember->Email_O = $formData['Email_O'] ?? "";

                if (isset($formData['isVerified'])) {
                    $newMember->isVerified = $formData['isVerified'] ? "Yes" : "No";
                }

                $newMember->save();

                if ($newMember->save()) {
                    ActivityLogHelper::log($adminId, 'Member Details Updated by admin', 'Updated member Details of ID ' . (string) $memberId);
                }

                return redirect('/admin/member-view')->with('success', 'Member information updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Member not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function deleteMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        $memberId = $request->id;

        $member = Member::where('adminId','=',$adminId)->find($request->id);
        // print_r($member);die;
        if ($member) {
            // $member->delete();
            
            $member->isDeleted = true;
            $member->save();

            // Remove the user ID from interestedMembers array
            Event::where('interestedMembers', $request->id)
            ->update([
                '$pull' => ['interestedMembers' => $request->id] 
            ]);

            // If interestedMembers is now empty, remove the field completely
            Event::whereRaw([
                'interestedMembers' => ['$exists' => true, '$size' => 0]
            ])->update([
                '$unset' => ['interestedMembers' => ""]
            ]);

            // Remove member from Teams' groupDetails dynamically
            $teams = Team::where('groupDetails', 'exists', true)->get();

            foreach ($teams as $team) {
                $updatedGroupDetails = $team->groupDetails;

                foreach ($updatedGroupDetails as &$group) {
                    foreach ($group as $key => &$roleArray) {
                        // Skip 'maxAssignedMembers' to avoid modifying it
                        if ($key === 'maxAssignedMembers') {
                            continue;
                        }
                
                        // Check if the key holds an array of members
                        if (is_array($roleArray)) {
                            $roleArray = array_filter($roleArray, function ($member) use ($memberId) {
                                // Safely check for 'memberId' and filter out matching member
                                return is_array($member) && isset($member['memberId']) && $member['memberId'] !== $memberId;
                            });

                            // Reindex the array after filtering
                            $roleArray = array_values($roleArray);
                        }
                    }
                }

                // Save the updated team
                $team->groupDetails = $updatedGroupDetails;
                $team->save();
            }

            // Update MemberHistory: Set positionEndDate to today if it's in the future
            $today = Carbon::now()->format('Ymd'); // YYYYMMDD format

            $memberHistory = MemberHistory::where('memberId', $memberId)->first();

            if ($memberHistory && isset($memberHistory->history)) {
                $updatedHistory = [];

                foreach ($memberHistory->history as $entry) {
                    if (isset($entry['positionEndDate']) && $entry['positionEndDate'] > $today) {
                        // Update positionEndDate if it's greater than today
                        $entry['positionEndDate'] = (int)$today;
                    }
                    $updatedHistory[] = $entry;
                }

                // Save updated history
                $memberHistory->history = $updatedHistory;
                $memberHistory->save();
            }

            return response()->json(['success' => 'Member deleted successfully.']);
        } else {
            return response()->json(['error' => 'Member not found.'], 404);
        }
    }

    public function reverifyMember($id)
    {
        $member = $newMember = Member::find($id);;
        // print_r($member);die;
    
        if ($member) {
            $member->isVerified = "reverified";
            $member->save();

            return redirect()->back()->with('success', 'Member reverified successfully.');
        }

        return redirect()->back()->with('error', 'Member not found.');
    }

    public function sendSms(Request $request)
    {
        $adminId = Session::get('admin_id');
        
        $mobileNumber = $request->input('mobile_number');

        $memberId = $request->input('memberId');
        $memberDetails = Member::where('adminId','=',$adminId)->find($memberId);
        $fullName = $memberDetails->Name . ' ' . $memberDetails->Middle_Name . ' ' . $memberDetails->Surname;
        $url = "http://bulksms.nkinfo.in/pushsms.php";

        // Prepare the query parameters
        $params = [
            'username' => 'SouthSabha',
            'api_password' => 'ac54bqbi852p0dpxf',
            'sender' => 'SABHAK',
            'to' => $mobileNumber,
            // 'group' => '',
            'message' => "$fullName
Kindly update Your Membership data & family details in the below link:
tinyurl.com/southsaba
South Sabha",
            // 'unicode' => 1,
            'priority' => '11',
            'e_id' => '1101421070000082837',
            't_id' => '1107173166091517554'
        ];

        // Send the request
        $response = Http::get($url, $params);

        // Check the response and return accordingly
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'SMS sent successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send SMS']);
        }
    }

    public function sendAllSms(Request $request)
    {
        $adminId = Session::get('admin_id');

        $selectedMembers = $request->input('selected_members');
        // $message = $request->input('message');

        // Loop through selected members and send SMS
        foreach ($selectedMembers as $member) {
            $mobileNumber = $member['mobile'];
            // $messageContent = $message; 
            $id = $member['memberId'];

            $memberDetails = Member::where('adminId','=',$adminId)->find($id);

            $fullName = $memberDetails->Name . ' ' . $memberDetails->Middle_Name . ' ' . $memberDetails->Surname;

            $url = "http://bulksms.nkinfo.in/pushsms.php";

            // Prepare the query parameters
            $params = [
                'username' => 'SouthSabha',
                'api_password' => 'ac54bqbi852p0dpxf',
                'sender' => 'SABHAK',
                'to' => $mobileNumber,
                // 'group' => '',
                'message' => "$fullName
Kindly update Your Membership data & family details in the below link:
tinyurl.com/southsaba
South Sabha",
                // 'unicode' => 1,
                'priority' => '11',
                'e_id' => '1101421070000082837',
                't_id' => '1107173166091517554'
            ];

            // Send the request
            $response = Http::get($url, $params);
        }

        return response()->json(['success' => $selectedMembers]);
    }

    public function filterVerify(Request $request)
    {
        $adminId = Session::get('admin_id');

        $status = $request->input('status');
        // print_r($status);die;
        $paginateInput = $request->input('paginateInput', 20);
        $query = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)
            ->orderBy('Name', 'asc')
            ->orderBy('Middle_Name', 'asc')
            ->orderBy('Surname', 'asc');

        if ($status === 'Yes') {
            $query->where('isVerified', $status);
        } else if ($status === 'No') {
            $query->where('isVerified', "!=", 'Yes')->where('isVerified', "!=", 'reverified');
        } else if ($status === 'reverified') {
            $query->where('isVerified', "=", 'reverified');
        } else {
        }

        $members = $query->paginate($paginateInput);
        return view('admin.membersView_search', compact('members', 'paginateInput'))->render();
    }

    public function downloadMembers(Request $request)
    {
        $adminId = Session::get('admin_id');

        $keyword = $request->input('keyword');
        $membersType = $request->input('membersType');
        $selectedMembers = $request->input('selected_members');
        $verifyInp = $request->input('verifyInp');
        // print_r($selectedMembers);die;

        // MongoDB aggregation pipeline
        $pipeline = [];

        $pipeline[] = [
                        '$match' => [
                            '$and' => [
                                ['adminId' => $adminId], 
                                ['isDeleted' => ['$ne' => true]]
                            ]
                        ]
                    ];

        // Apply filter by member type if selected
        if ($membersType && $membersType !== 'all') {
            $pipeline[] = ['$match' => ['Members_Type' => $membersType]];
        }

        if ($verifyInp == 'Yes') {
            $pipeline[] = ['$match' => ['isVerified' => $verifyInp]];
        }

        if ($verifyInp == 'reverified') {
            $pipeline[] = ['$match' => ['isVerified' => $verifyInp]];
        }

        if ($verifyInp == 'No') {
            $pipeline[] = ['$match' => ['isVerified' => null]];
        }

        // Apply search filter for Name, Middle Name, Surname or Mobile
        if ($keyword) {
            $pipeline[] = [
                '$addFields' => [
                    'Mobile_String' => [
                        '$toString' => '$Mobile' // Convert Mobile field to a string
                    ]
                ]
            ];
            $pipeline[] = [
                '$match' => [
                    '$or' => [
                        ['Name' => ['$regex' => '^' . $keyword, '$options' => 'i']],
                        ['Middle_Name' => ['$regex' => '^' . $keyword, '$options' => 'i']],
                        ['Surname' => ['$regex' => '^' . $keyword, '$options' => 'i']],
                        ['Mobile_String' => ['$regex' => '^' . $keyword, '$options' => 'i']],
                    ]
                ]
            ];
        }

        // Apply filter for selected members if any IDs are provided
        if ($selectedMembers) {
            $selectedMemberIds = explode(',', $selectedMembers); // Convert comma-separated string to an array
            $pipeline[] = ['$match' => ['_id' => ['$in' => array_map(function ($id) {
                return new ObjectId($id); // Convert each ID to MongoDB ObjectId
            }, $selectedMemberIds)]]];
        }

        // Fetch all members sorted by created_at date
        // $pipeline[] = ['$sort' => ['created_at' => -1]];
        $pipeline[] = ['$sort' => ['Name' => 1, 'Middle_Name' => 1, 'Surname' => 1]];

        $members = Member::raw(function ($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });

        // Initialize PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers for Excel columns
        $sheet->setCellValue('A1', 'Membership No.');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Mobile No.');
        $sheet->setCellValue('D1', 'Members Type');
        $sheet->setCellValue('E1', "Father's Name");
        $sheet->setCellValue('F1', 'Spouse Name');
        $sheet->setCellValue('G1', 'Gender');
        $sheet->setCellValue('H1', 'hasTerapanthCard');
        $sheet->setCellValue('I1', 'Date of Birth');
        $sheet->setCellValue('J1', 'Age');
        $sheet->setCellValue('K1', 'Date of Marriage');
        $sheet->setCellValue('L1', 'Blood Group');
        $sheet->setCellValue('M1', 'Qualification');
        $sheet->setCellValue('N1', 'Occupation');
        $sheet->setCellValue('O1', 'Alt. Phone Number');
        $sheet->setCellValue('P1', 'Email_ID');
        $sheet->setCellValue('Q1', 'Residential Address');
        $sheet->setCellValue('R1', 'Residential Pincode');
        $sheet->setCellValue('S1', 'Native Place');
        $sheet->setCellValue('T1', 'Residential Phone');
        $sheet->setCellValue('U1', 'Business Name');
        $sheet->setCellValue('V1', 'Office Address');
        $sheet->setCellValue('W1', 'Office Pincode');
        $sheet->setCellValue('X1', 'Deals In');
        $sheet->setCellValue('Y1', 'Office Phone');
        $sheet->setCellValue('Z1', 'Office Mobile');
        $sheet->setCellValue('AA1', 'Office Email');
        $sheet->setCellValue('AB1', '1st Family Member Details');
        $sheet->setCellValue('AC1', '2nd Family Member Details');
        $sheet->setCellValue('AD1', '3rd Family Member Details');
        $sheet->setCellValue('AE1', '4th Family Member Details');
        $sheet->setCellValue('AF1', '5th Family Member Details');
        $sheet->setCellValue('AG1', '6th Family Member Details');
        $sheet->setCellValue('AH1', 'Is Verified');

        // Populate the Excel sheet with member data
        $row = 2;
        foreach ($members as $member) {
            $sheet->getRowDimension($row)->setRowHeight(50);

            $sheet->setCellValue('A' . $row, $member['Membership_No'] ?? '');
            $sheet->setCellValue('B' . $row, ($member['Name'] ?? '') . ' ' . ($member['Middle_Name'] ?? '') . ' ' . ($member['Surname'] ?? ''));
            $sheet->setCellValue('C' . $row, $member['Mobile'] ?? '');
            $sheet->setCellValue('D' . $row, $member['Members_Type'] ?? '');
            $sheet->setCellValue('E' . $row, $member['Son_Daughter_of'] ?? '');
            $sheet->setCellValue('F' . $row, $member['Spouse'] ?? '');
            $sheet->setCellValue('G' . $row, $member['gender'] ?? '');
            $sheet->setCellValue('H' . $row, $member['hasTerapanthCard'] ?? '');
            $sheet->setCellValue('I' . $row, $member['DOB'] ?? '');
            $sheet->setCellValue('J' . $row, $member['age'] ?? '');
            $sheet->setCellValue('K' . $row, $member['DOM'] ?? '');
            $sheet->setCellValue('L' . $row, $member['bloodGroup'] ?? '');
            $sheet->setCellValue('M' . $row, $member['Qualification'] ?? '');
            $sheet->setCellValue('N' . $row, $member['Occupation'] ?? '');
            $sheet->setCellValue('O' . $row, $member['alternateNumber'] ?? '');
            $sheet->setCellValue('P' . $row, $member['Email_ID'] ?? '');
            $sheet->setCellValue('Q' . $row, ($member['Residence1'] ?? '') . ' ' . ($member['Residence2'] ?? '') . ' ' . ($member['Residence3'] ?? '') . ' ' . ($member['Residence4'] ?? '') . ' ');
            $sheet->setCellValue('R' . $row, $member['Res_PINCODE'] ?? '');
            $sheet->setCellValue('S' . $row, $member['Native_Place'] ?? '');
            $sheet->setCellValue('T' . $row, $member['Phone'] ?? '');
            $sheet->setCellValue('U' . $row, $member['businessName'] ?? '');
            $sheet->setCellValue('V' . $row, ($member['Office-1'] ?? '') . ' ' . ($member['Office-2'] ?? '') . ' ' . ($member['Office-3'] ?? '') . ' ' . ($member['Office-4'] ?? '') . ' ');
            $sheet->setCellValue('W' . $row, $member['PINCODE'] ?? '');
            $sheet->setCellValue('X' . $row, $member['dealsIn'] ?? '');
            $sheet->setCellValue('Y' . $row, $member['Phone_O'] ?? '');
            $sheet->setCellValue('Z' . $row, $member['Mobile_O'] ?? '');
            $sheet->setCellValue('AA' . $row, $member['Email_O'] ?? '');
            $sheet->setCellValue(
                'AB' . $row,
                ($member['familyMember1Name'] ? "Name: " . $member['familyMember1Name'] . "\n" : '') .
                    ($member['familyMember1Phone'] ? "Phone: " . $member['familyMember1Phone'] . "\n" : '') .
                    ($member['familyMember1Relation'] ? "Relation: " . $member['familyMember1Relation'] : '')
            );
            $sheet->getStyle('AB' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue(
                'AC' . $row,
                ($member['familyMember2Name'] ? "Name: " . $member['familyMember2Name'] . "\n" : '') .
                    ($member['familyMember2Phone'] ? "Phone: " . $member['familyMember2Phone'] . "\n" : '') .
                    ($member['familyMember2Relation'] ? "Relation: " . $member['familyMember2Relation'] : '')
            );
            $sheet->getStyle('AC' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue(
                'AD' . $row,
                ($member['familyMember3Name'] ? "Name: " . $member['familyMember3Name'] . "\n" : '') .
                    ($member['familyMember3Phone'] ? "Phone: " . $member['familyMember3Phone'] . "\n" : '') .
                    ($member['familyMember3Relation'] ? "Relation: " . $member['familyMember3Relation'] : '')
            );
            $sheet->getStyle('AD' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue(
                'AE' . $row,
                ($member['familyMember4Name'] ? "Name: " . $member['familyMember4Name'] . "\n" : '') .
                    ($member['familyMember4Phone'] ? "Phone: " . $member['familyMember4Phone'] . "\n" : '') .
                    ($member['familyMember4Relation'] ? "Relation: " . $member['familyMember4Relation'] : '')
            );
            $sheet->getStyle('AE' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue(
                'AF' . $row,
                ($member['familyMember5Name'] ? "Name: " . $member['familyMember5Name'] . "\n" : '') .
                    ($member['familyMember5Phone'] ? "Phone: " . $member['familyMember5Phone'] . "\n" : '') .
                    ($member['familyMember5Relation'] ? "Relation: " . $member['familyMember5Relation'] : '')
            );
            $sheet->getStyle('AF' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue(
                'AG' . $row,
                ($member['familyMember6Name'] ? "Name: " . $member['familyMember6Name'] . "\n" : '') .
                    ($member['familyMember6Phone'] ? "Phone: " . $member['familyMember6Phone'] . "\n" : '') .
                    ($member['familyMember6Relation'] ? "Relation: " . $member['familyMember6Relation'] : '')
            );
            $sheet->getStyle('AG' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('AH' . $row, $member['isVerified'] ?? '');

            $row++;
        }

        // Generate and download Excel file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'members_data.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
