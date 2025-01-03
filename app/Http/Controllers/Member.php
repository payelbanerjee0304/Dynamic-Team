<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\ActivityLogHelper;
use MongoDB\BSON\ObjectId;

use App\Models\Member as MemberModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Member extends Controller
{

    public function addMember()
    {
        return view('member.addMember');
    }

    public function insertMember1(Request $request)
    {

        $formData = $request->all();
        echo "<pre>";
        print_r($formData);die;

        $newMember = new MemberModel();

        // $membership = [
        //     'number' => $formData['memberNumber'],
        //     'type' => $formData['memberType'],
        //     'surname' => $formData['memberSurname'],
        //     'name' => $formData['memberName'],
        //     'guardianName' => $formData['guardianName'],
        //     'spouseName' => $formData['spouseName'],
        //     'hasTerapanthCard' => $formData['hasTerapanthCard'] == "Yes" ? true : false,
        // ];

        // $personal = [
        //     'dateOfBirth' => (int) date('Ymd', strtotime($formData['dateOfBirth'])),
        //     'age' => (int) $formData['age'],
        //     'dateOfMarriage' => (int) date('Ymd', strtotime($formData['dateOfMarriage'])),
        //     'bloodGroup' => $formData['bloodGroup'],
        //     'qualification' => $formData['qualification'],
        //     'occupation' => $formData['occupation'],
        //     'mobileNumber' => (int) $formData['mobileNumber'],
        //     'alternateNumber' => (int) $formData['alternateNumber'],
        //     'emailId' => $formData['emailId'],
        //     'image' => $formData['image'],
        // ];

        // $residential = [
        //     "residenceAddress" => $formData['residenceAddress'],
        //     "pincode" => $formData['pincode'],
        //     "nativePlace" => $formData['nativePlace'],
        //     "phoneNumber" => (int) $formData['phoneNumber'],
        //     "familyDetails" => $formData['familyDetails'],
        // ];


        // $business = [
        //     "name" => $formData['businessName'],
        //     "address" => $formData['businessAddress'],
        //     "pincode" => $formData['businessPin'],
        //     "faxNumber" => $formData['businessFaxNo']
        // ];

        $newMember->Members_Type = $formData['Members_Type'];
        $newMember->Membership_No = $formData['Membership_No'];
        $newMember->Name = $formData['Name'];
        $newMember->Surname = $formData['Surname'];
        $newMember->Middle_Name = "";
        $newMember->Son_Daughter_of = $formData['Son_Daughter_of'];
        $newMember->Res_PINCODE = $formData['Res_PINCODE'];
        $newMember->Phone = $formData['Phone'];

        $newMember->Mobile = $formData['Mobile'];
        $newMember->Email_ID = $formData['Email_ID'];
        $newMember->PINCODE = $formData['PINCODE'];
        $newMember->Phone_O = $formData['Phone_O'];
        $newMember->Mobile_O = $formData['Mobile_O'] ?? "";
        $newMember->Email_ID_O = $formData['Email_ID_O'] ?? "";
        $newMember->Qualification = $formData['Qualification'];
        $newMember->Occupation = $formData['Occupation'];
        $newMember->Deals_In = $formData['Deals_In'] ?? "";
        $newMember->DOB = $formData['DOB'];
        $newMember->DOM = $formData['DOM'];
        $newMember->Spouse = $formData['Spouse'];
        $newMember->Native_Place = $formData['Native_Place'];


        $newMember->hasTerapanthCard = $formData['hasTerapanthCard'];
        $newMember->age = $formData['age'];
        $newMember->bloodGroup = $formData['bloodGroup'];
        $newMember->alternateNumber = $formData['alternateNumber'];
        // $newMember->image = $formData['image'];

        $newMember->familyDetails = $formData['familyDetails'];
        $newMember->businessName = $formData['businessName'];
        $newMember->businessFaxNo = $formData['businessFaxNo'];


        $residenceAddress =  explode(',', $formData['residenceAddress']);

        $newMember->Residence1 = $residenceAddress[0] ?? "";
        $newMember->Residence2 = $residenceAddress[1] ?? "";
        $newMember->Residence3 = $residenceAddress[2] ?? "";
        $newMember->Residence4 = $residenceAddress[4] ?? "";

        $businessAddress = explode(',', $formData['businessAddress']);

        $newMember['Office-1'] = $businessAddress[0] ?? "";
        $newMember['Office-2'] = $businessAddress[1] ?? "";
        $newMember['Office-3'] = $businessAddress[2] ?? "";
        $newMember['Office-4'] = $businessAddress[3] ?? "";


        $newMember->save();

        // echo "<pre>";

        // print_r(json_encode($formData, true));

        return redirect()->back();
    }

    public function insertMember(Request $request)
    {
        $adminId = Session::get('admin_id');
        $formData = $request->all();
        // echo "<pre>";
        // print_r($formData);die;

        $newMember = new MemberModel();

        $newMember->Membership_No = $formData['Membership_No'];
        $newMember->Members_Type = $formData['Members_Type'];
        $newMember->Surname = $formData['Surname'] ?? "";
        $newMember->Name = $formData['Name'] ?? "";
        $newMember->Middle_Name = $formData['MidName'] ?? "";
        $newMember->Son_Daughter_of = $formData['Son_Daughter_of'] ?? "";
        $newMember->Spouse = $formData['Spouse'] ?? "";
        $newMember->hasTerapanthCard = $formData['hasTerapanthCard'];


        $newMember->DOB = $formData['DOB'] ?? "";
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

        if($request->file('image'))
        {
            $file=$request->file('image');
            $filename=time()."_".$file->getClientOriginalName();
            $uploadlocation="./upload";
            $file->move($uploadlocation,$filename);
            $newMember->image=$uploadlocation.'/'.$filename;
        }

        $newMember->PINCODE = $formData['PINCODE'] ?? "";
        $newMember->dealsIn = $formData['dealsIn'] ?? "";
        $newMember->Phone_O = $formData['Phone_O'] ?? "";
        $newMember->Mobile_O = $formData['Mobile_O'] ?? "";
        $newMember->businessFaxNo = $formData['businessFaxNo'] ?? "";

        $newMember->save();
        ActivityLogHelper::log($adminId, 'Member Created', 'Member inserted by ID ' . (string) $adminId );
        
        return redirect('/admin/view')->with('success', 'Member information inserted successfully.');
    }

    public function allMembers()
    {
        $members = MemberModel::orderBy('created_at','desc')->paginate(20);
        return view('member.members', compact('members'));
    }

    public function paginateMember(Request $request)
    {
        $members = MemberModel::orderBy('created_at', 'desc')->paginate(20);
        return view('member.members_pagination', compact('members'))->render();
    }

    public function searchMember(Request $request)
    {
        $keyword = $request->input('keyword');
        $members = MemberModel::where('Name', 'LIKE', "%{$keyword}%")
                        ->orWhere('Surname', 'LIKE', "%{$keyword}%")
                        ->orWhere('Middle_Name', 'LIKE', "%{$keyword}%")
                        ->OrderBy('created_at', 'desc')
                        ->paginate(20);

        return view('member.members_search', compact('members'))->render();
    }

    public function suggestMembers(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = MemberModel::where('Name', 'LIKE', "%{$keyword}%")
                            ->orWhere('Surname', 'LIKE', "%{$keyword}%")
                            ->orWhere('Middle_Name', 'LIKE', "%{$keyword}%")
                            ->orderBy('Name', 'asc')
                            ->pluck('Name'); // Or select additional fields if needed

        // Return HTML for each suggestion
        $output = '';
        foreach ($suggestions as $suggestion) {
            $output .= '<div>' . e($suggestion) . '</div>';
        }
        
        return response()->json($output);
    }

    public function filterMember(Request $request)
    {
        $membersType = $request->input('membersType', 'all');
        $query = MemberModel::orderBy('created_at', 'desc');

        if ($membersType !== 'all') {
            $query->where('Members_Type', $membersType);
        }

        $members = $query->paginate(20);
        return view('member.members_search', compact('members'))->render();
    }

    public function editMember($id)
    {
        $member = MemberModel::where('_id', $id)->first();
        return view('member.editMember', compact('member'));
    }

    public function updateMember(Request $request)
    {
        $formData = $request->all();

        $memberId = $formData['memberId'];

        $member =  MemberModel::where("_id", $memberId)->first();

        echo "<pre>";

        // print_r($member);

        // print_r($formData);

        $member['Membership_No'] = $formData['Membership_No'];

        $member->save();
    }

    public function view(){
        return view('admin.view');
    }

    public function downloadMemberData($id)
    {
        // Fetch the member data by ID
        $member = MemberModel::find($id);

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define the headers and the respective member data
        $headers = [
            'Membership No.', 'Name', 'Middle Name', 'Surname', 'Phone No.', 'Members Type',
            'Spouse', 'hasTerapanthCard', 'DOB', 'Age', 'DOM', 'Blood Group', 'Qualification', 'Occupation', 
            'Mobile', 'Alternate Number', 'Email ID', 'Premises No.', 'Street Name', 'Area', 'City', 
            'Res. Pincode', 'Native Place', 'Phone', 'Business Name', 'Business Premises No.', 'Business Street Name', 'Business Area', 'Business City', 
            'Pincode', 'Deals In', 'Phone Office', 'Mobile Office', 'Email Office', '1st Family Member Name', 
            '1st Family Member Phone', '1st Family Member Relation', 
            '2nd Family Member Name', '2nd Family Member Phone', '2nd Family Member Relation', '3rd Family Member Name', 
            '3rd Family Member Phone', '3rd Family Member Relation', '4th Family Member Name', '4th Family Member Phone', 
            '4th Family Member Relation', '5th Family Member Name', '5th Family Member Phone', '5th Family Member Relation', 
            '6th Family Member Name', '6th Family Member Phone', '6th Family Member Relation'
        ];

        // Corresponding values from the member data
        $data = [
            $member['Membership_No'], $member['Name'], $member['Middle_Name'], $member['Surname'], $member['Mobile'], 
            $member['Members_Type'], $member['Spouse'], $member['hasTerapanthCard'], 
            $member['DOB'], $member['age'], $member['DOM'], $member['bloodGroup'], $member['Qualification'], 
            $member['Occupation'], $member['Mobile'], $member['alternateNumber'], $member['Email_ID'], 
            $member['Residence1'], $member['Residence2'], $member['Residence3'], $member['Residence4'], 
            $member['Res_PINCODE'], $member['Native_Place'], $member['Phone'], $member['businessName'], 
            $member['Office-1'], $member['Office-2'], $member['Office-3'], $member['Office-4'], 
            $member['PINCODE'], $member['dealsIn'], $member['Phone_O'], $member['Mobile_O'],$member['Email_O'], 
            $member['familyMember1Name'], 
            $member['familyMember1Phone'], $member['familyMember1Relation'], $member['familyMember2Name'], 
            $member['familyMember2Phone'], $member['familyMember2Relation'], $member['familyMember3Name'], 
            $member['familyMember3Phone'], $member['familyMember3Relation'], $member['familyMember4Name'], 
            $member['familyMember4Phone'], $member['familyMember4Relation'], $member['familyMember5Name'], 
            $member['familyMember5Phone'], $member['familyMember5Relation'], $member['familyMember6Name'], 
            $member['familyMember6Phone'], $member['familyMember6Relation']
        ];

        // Populate the sheet with headers and member data
        foreach ($headers as $index => $header) {
            $sheet->setCellValue('A' . ($index + 1), $header);
            $sheet->setCellValue('B' . ($index + 1), $data[$index]);
        }

        // Generate the Excel file and download
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Member_' . $member['Membership_No'] . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        $writer->save('php://output');
        exit;
    }

    public function downloadMembers(Request $request)
    {
        $keyword = $request->input('keyword');
        $membersType = $request->input('membersType');
        $selectedMembers = $request->input('selected_members');
        $verifyInp= $request->input('verifyInp');
        // print_r($selectedMembers);die;

        // MongoDB aggregation pipeline
        $pipeline = [];

        $pipeline[] = ['$match' => ['isDeleted' => ['$ne' => true]]];

        // Apply filter by member type if selected
        if ($membersType && $membersType !== 'all') {
            $pipeline[] = ['$match' => ['Members_Type' => $membersType]];
        }

        if ($verifyInp) {
            $pipeline[] = ['$match' => ['isVerified' => $verifyInp]];
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
            $pipeline[] = ['$match' => ['_id' => ['$in' => array_map(function($id) {
                return new ObjectId($id); // Convert each ID to MongoDB ObjectId
            }, $selectedMemberIds)]]];
        }

        // Fetch all members sorted by created_at date
        // $pipeline[] = ['$sort' => ['created_at' => -1]];
        $pipeline[] = ['$sort' => ['Name' => 1, 'Middle_Name' => 1, 'Surname' => 1]];

        $members = MemberModel::raw(function ($collection) use ($pipeline) {
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
            $sheet->setCellValue('AB' . $row, 
                ($member['familyMember1Name'] ? "Name: " . $member['familyMember1Name'] . "\n" : '') .
                ($member['familyMember1Phone'] ? "Phone: " . $member['familyMember1Phone'] . "\n" : '') .
                ($member['familyMember1Relation'] ? "Relation: " . $member['familyMember1Relation'] : '')
            );
            $sheet->getStyle('AB' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('AC' . $row, 
                ($member['familyMember2Name'] ? "Name: " . $member['familyMember2Name'] . "\n" : '') .
                ($member['familyMember2Phone'] ? "Phone: " . $member['familyMember2Phone'] . "\n" : '') .
                ($member['familyMember2Relation'] ? "Relation: " . $member['familyMember2Relation'] : '')
            );
            $sheet->getStyle('AC' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('AD' . $row, 
            ($member['familyMember3Name'] ? "Name: " . $member['familyMember3Name'] . "\n" : '') .
            ($member['familyMember3Phone'] ? "Phone: " . $member['familyMember3Phone'] . "\n" : '') .
            ($member['familyMember3Relation'] ? "Relation: " . $member['familyMember3Relation'] : '')
            );
            $sheet->getStyle('AD' . $row)->getAlignment()->setWrapText(true);
            
            $sheet->setCellValue('AE' . $row, 
                ($member['familyMember4Name'] ? "Name: " . $member['familyMember4Name'] . "\n" : '') .
                ($member['familyMember4Phone'] ? "Phone: " . $member['familyMember4Phone'] . "\n" : '') .
                ($member['familyMember4Relation'] ? "Relation: " . $member['familyMember4Relation'] : '')
            );
            $sheet->getStyle('AE' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('AF' . $row, 
                ($member['familyMember5Name'] ? "Name: " . $member['familyMember5Name'] . "\n" : '') .
                ($member['familyMember5Phone'] ? "Phone: " . $member['familyMember5Phone'] . "\n" : '') .
                ($member['familyMember5Relation'] ? "Relation: " . $member['familyMember5Relation'] : '')
            );
            $sheet->getStyle('AF' . $row)->getAlignment()->setWrapText(true);

            $sheet->setCellValue('AG' . $row, 
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
