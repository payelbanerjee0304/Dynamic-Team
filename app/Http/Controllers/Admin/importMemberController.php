<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Member;
use App\Models\MemberTest;

class importMemberController extends Controller
{
    
    public function importMembersPage()
    {
        return view('admin.importMembers');
    }

    public function importMembersInsert(Request $request)
    {

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            foreach ($rows as $index => $row) {
                
                if ($index === 0) continue;

                $newMember = new MemberTest();
                $newMember->S_No= $row[1] ?? null;
                $newMember->Members_Type = $row[2] ?? null;
                $newMember->Membership_No = $row[3] ?? null;
                $newMember->Surname = $row[4] ?? null;
                $newMember->Name= $row[5] ?? null;
                $newMember->Middle_Name= $row[6] ?? null;
                $newMember->Son_Daughter_of= $row[7] ?? null;
                $newMember->Residence1= $row[8] ?? null;
                $newMember->Residence2= $row[9] ?? null;
                $newMember->Residence3= $row[10] ?? null;
                $newMember->Residence4= $row[11] ?? null;
                $newMember->Res_PINCODE= $row[12] ?? null;
                $newMember->Phone= $row[13] ?? null;
                $newMember->Mobile= $row[14] ?? null;
                $newMember->Email_ID= $row[15] ?? null;
                $newMember->{'Office-1'}= $row[16] ?? null;
                $newMember->{'Office-2'}= $row[17] ?? null;
                $newMember->{'Office-3'}= $row[18] ?? null;
                $newMember->{'Office-4'}= $row[19] ?? null;
                $newMember->PINCODE= $row[20] ?? null;
                $newMember->Phone_O= $row[21] ?? null;
                $newMember->Mobile_O= $row[22] ?? null;
                $newMember->Email_ID_O= $row[23] ?? null;
                $newMember->Qualification= $row[24] ?? null;
                $newMember->Occupation= $row[25] ?? null;
                $newMember->Deals_In= $row[26] ?? null;
                $newMember->DOB= $row[27] ?? null;
                $newMember->DOM= $row[28] ?? null;
                $newMember->Spouse= $row[29] ?? null;
                $newMember->Native_Place= $row[30] ?? null;
                $newMember->hasTerapanthCard= $row[33] ?? null;
                $newMember->age= $row[34] ?? null;
                $newMember->alternateNumber= $row[35] ?? null;
                $newMember->bloodGroup= $row[36] ?? null;
                $newMember->businessName= $row[38] ?? null;
                $newMember->Email_O= $row[40] ?? null;
                $newMember->familyMember1Name= $row[42] ?? null;
                $newMember->familyMember1Phone= $row[43] ?? null;
                $newMember->familyMember1Relation= $row[44] ?? null;
                $newMember->familyMember2Name= $row[45] ?? null;
                $newMember->familyMember2Phone= $row[46] ?? null;
                $newMember->familyMember2Relation= $row[47] ?? null;
                $newMember->familyMember3Name= $row[48] ?? null;
                $newMember->familyMember3Phone= $row[49] ?? null;
                $newMember->familyMember3Relation= $row[50] ?? null;
                $newMember->familyMember4Name= $row[51] ?? null;
                $newMember->familyMember4Phone= $row[52] ?? null;
                $newMember->familyMember4Relation= $row[53] ?? null;
                $newMember->familyMember5Name= $row[54] ?? null;
                $newMember->familyMember5Phone= $row[55] ?? null;
                $newMember->familyMember5Relation= $row[56] ?? null;
                $newMember->familyMember6Name= $row[57] ?? null;
                $newMember->familyMember6Phone= $row[58] ?? null;
                $newMember->familyMember6Relation= $row[59] ?? null;
                $newMember->gender= $row[60] ?? null;
                $newMember->isVerified= $row[61] ?? null;
                $newMember->save();

            }

            return redirect()->back()->with('success', 'Members imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing members: ' . $e->getMessage());
        }
    }
}
