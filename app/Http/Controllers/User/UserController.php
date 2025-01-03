<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;

use App\Models\Member;



class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }
    public function save(Request $request)
    {
        $request->validate([]);

        // $email = $request->input('email');
        // $password = md5($request->input('password'));
        $mobile = $request->input('mobile');
        $user = Member::where('Mobile', '=', $mobile)->orWhere('Mobile', '=', (int)$mobile)->where('isDeleted', '!=', true)->get();

        if (empty($user[0])) {
            return response()->json(['status' => 'error', 'message' => 'Member not found']);
        }
        // else if ($user[0]['password']!=$password) {
        //     return response()->json(['status' => 'error', 'message' => 'Password is incorrect']);
        // } 
        else {
            $otp = rand(100000, 999999);
            $var = ['otp' => $otp];
            Member::where('Mobile', '=', $mobile)->orWhere('Mobile', '=', (int)$mobile)->update($var);
            $getDataOtp = Member::where('Mobile', '=', $mobile)->orWhere('Mobile', '=', (int)$mobile)->get();


            // $url = "http://bulksms.nkinfo.in/pushsms.php";

            // // Prepare the query parameters
            // $params = [
            //     'username' => 'SouthSabha',
            //     'api_password' => 'ac54bqbi852p0dpxf',
            //     'sender' => 'SABHAK',
            //     'to' => $mobile,
            //     // 'group' => '',
            //     'message' => "{$otp} is the One Time Password (OTP) for your login. Please do not share with anyone.SOUTH CALCUTTA SHRI JAIN SWETAMBER TERAPANTHI SABHA",
            //     // 'unicode' => 1,
            //     'priority' => '11',
            //     'e_id' => '1101421070000082837',
            //     't_id' => '1107173045874845435'
            // ];

            // // Send the request
            // $response = Http::get($url, $params);
            // print_r($response);die;

            return response($getDataOtp);
        }
    }
    public function verifyAndLogin(Request $request)
    {

        // $email=$request->input('email');
        // $password=md5($request->input('password'));
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');
        $user = Member::where('Mobile', '=', $mobile)->orWhere('Mobile', '=', (int)$mobile)->get();
        // console.log($userDetails);
        if (empty($otp)) {
            return response()->json(['status' => 'error', 'message' => 'Please Enter Your One Time Password'], 404);
        } else if ($user[0]['otp'] != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Wrong OTP'], 404);
        } else {
            // return response()->json(['status' => 'success', 'message' => 'Form submitted successfully']);
            Session::put('user', $user);
            session(['user_id' => $user[0]['_id']]);
            if (Session::has('user_id')) {
                // Retrieve the value of the session variable
                $userId = Session::get('user_id');
                // Use or display the value
                // session(['user_id' => $user[0]->id]);
                return response()->json(['status' => 'success', 'user' => $user]);
            } else {
                echo "User ID session variable not set";
            }
        }
    }
    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        return redirect('/login')->with('message', 'Logout successfully');
    }

    public function addMemberSession()
    {
        $userId = Session::get('user_id');
        $member = Member::where('_id', $userId)->first();
        return view('user.editMember', compact('member'));
    }

    public function updateMemberSession(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $userId = Session::get('user_id'); // Get the logged-in user ID from session
        $memberId = $request->input('memberId'); // Get memberId from the form data

        if ($userId == $memberId) {
            // Assuming you have a Member model, retrieve the member and update their information
            $newMember = Member::find($memberId);

            if ($newMember) {
                $formData = $request->all();
                // $newMember->Membership_No = $formData['Membership_No'] ?? "";
                // $newMember->Members_Type = $formData['Members_Type'] ?? "";
                $newMember->Surname = $formData['Surname'] ?? "";
                $newMember->Name = $formData['Name'] ?? "";
                $newMember->Middle_Name = $formData['MidName'] ?? "";
                $newMember->Son_Daughter_of = $formData['Son_Daughter_of'] ?? "";
                $newMember->Spouse = $formData['Spouse'] ?? "";
                $newMember->gender = $formData['gender'] ?? "";
                $newMember->hasTerapanthCard = $formData['hasTerapanthCard'] ?? "";


                $newMember->DOB = $formData['DOB'] ?? "";
                $newMember->age = $formData['age'] ?? "";
                $newMember->DOM = $formData['DOM'] ?? "";
                $newMember->bloodGroup = $formData['bloodGroup'] ?? "";
                $newMember->Qualification = $formData['Qualification'] ?? "";
                $newMember->Occupation = $formData['Occupation'] ?? "";
                // $newMember->Mobile = $formData['Mobile'] ?? "";
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

                    // $uploadLocation = public_path('upload');
                    $uploadLocation = "./upload";
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

                    // $s3BucketFolder = 'southjstimages';
                    // $s3FilePath = $s3BucketFolder . '/' . $filename;
                    // Storage::disk('s3')->put($s3FilePath, file_get_contents($localFilePath));
                    // $fileLink = Storage::disk('s3')->url($s3FilePath);
                    $newMember->image = $localFilePath;


                    // if (file_exists($localFilePath)) {
                    //     unlink($localFilePath);
                    // }
                }



                $newMember->PINCODE = $formData['PINCODE'] ?? "";
                $newMember->Deals_In = $formData['Deals_In'] ?? "";
                $newMember->Phone_O = $formData['Phone_O'] ?? "";
                $newMember->Mobile_O = $formData['Mobile_O'] ?? "";
                // $newMember->businessFaxNo = $formData['businessFaxNo'] ?? "";
                $newMember->Email_O = $formData['Email_O'] ?? "";
                $newMember->isVerified = 'Yes';

                $newMember->save();

                // ActivityLogHelper::log($userId, 'Member Details Updated', 'Member updated Details with ID ' . (string) $userId);

                if ($newMember->save()) {
                    $request->session()->forget('user_id');
                }

                return redirect('/view')->with('success', 'Member information updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Member not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function view()
    {
        return view('user.view');
    }
    public function memberDetails()
    {

        $userId = Session::get('user_id');
        $member = Member::where('_id', $userId)->first();
        return view('user.memberDetails', compact('member'));
    }
}
