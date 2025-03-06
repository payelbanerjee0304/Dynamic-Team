<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Member;
use App\Models\Designation;

class DesignationAdminController extends Controller
{
    public function createNewDesignation()
    {
        return view('admin.designationCreate');
    }
    public function insertNewDesignation(Request $request)
    {
        $adminId = Session::get('admin_id');
        // echo "<pre>";
        // print_r($request->all());
        $formData = $request->all();

        $designation= new Designation;

        $designation->designation = $formData['dsg'] ?? "";
        $designation->hindi_designation = $formData['dsghindi'] ?? "";
        $designation->adminId = $adminId;

        $designation->save();

        return redirect('admin/all-designation')->with('success', 'Designation inserted successfully.');
    }

    public function allDesignation()
    {
        $adminId = Session::get('admin_id');

        $allDesignation = Designation::where('adminId','=',$adminId)->where('isDeleted', '!=',true)->orderBy('created_at', 'desc')->get();
        return view("admin.allDesignation", compact('allDesignation'));
    }

    public function deleteDesignation(Request $request)
    {
        $adminId = Session::get('admin_id');
        $designation = Designation::where('adminId','=',$adminId)->find($request->id);
        if ($designation) {
            $designation->isDeleted = true;
            $designation->save();
            return response()->json(['success' => 'Designation deleted successfully.']);
        } else {
            return response()->json(['error' => 'Designation not found.'], 404);
        }
    }

    public function editDesignation($id)
    {
        $designation = Designation::where('adminId','=',$adminId)->where('_id', $id)->first();
        return view('admin.designationEdit', compact('designation'));
    }

    public function updateDesignation(Request $request)
    {
        $dsgId = $request->input('dsgId'); // Get memberId from the form data

        if ($dsgId) {
            $designation = Designation::where('adminId','=',$adminId)->find($dsgId);

            if ($designation) {

                $formData = $request->all();

                $designation->designation = $formData['dsg'] ?? "";
                $designation->hindi_designation = $formData['dsghindi'] ?? "";
                
                $designation->save();

                return redirect('admin/all-designation')->with('success', 'Designation updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Designation not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }
    
}
