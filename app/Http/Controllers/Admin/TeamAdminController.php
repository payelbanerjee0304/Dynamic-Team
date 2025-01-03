<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;
use App\Models\Member;
use App\Models\Team;
use App\Models\MemberHistory;

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeamAdminController extends Controller
{
    public function createNewTeam()
    {
        return view('admin.teamCreate');
    }
    public function insertNewTeam(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;

        $formData = $request->all();

        $tenure=$formData['dateRange'];
        $tenureDates = explode(' to ', $tenure);
        $startDate = Carbon::createFromFormat('d-m-Y', $tenureDates[0])->format('Ymd');
        $endDate = Carbon::createFromFormat('d-m-Y', $tenureDates[1])->format('Ymd');

        $team= new Team;

        $team->teamName = $formData['team'] ?? "";
        $team->tenure = $formData['dateRange'] ?? "";
        $team->startDate = (int) $startDate ?? "";
        $team->endDate = (int) $endDate ?? "";
        $team->isActive= true;

        $team->save();

        return redirect('admin/all-team')->with('success', 'Team inserted successfully.');
    }

    public function editTeamDetails($id)
    {
        $team = Team::where('_id', $id)->first();

        return view('admin.teamEdit', compact('id','team'));
    }

    public function updateTeamDetails(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $formData = $request->all();
        
        // print_r($team);die;
        $tenure=$formData['dateRange'];
        $tenureDates = explode(' to ', $tenure);
        $startDate = Carbon::createFromFormat('d-m-Y', $tenureDates[0])->format('Ymd');
        $endDate = Carbon::createFromFormat('d-m-Y', $tenureDates[1])->format('Ymd');

        $team = Team::find($formData['teamId']);

        if ($team) {

            $team->teamName = $formData['team'] ?? "";
            $team->tenure = $formData['dateRange'] ?? "";
            $team->startDate = (int) $startDate ?? "";
            $team->endDate = (int) $endDate ?? "";

            $team->save();
        }

        return redirect('admin/all-team')->with('success', 'Team updated successfully.');
    }

    public function deleteTeam(Request $request)
    {
        $team = Team::find($request->id);
        if ($team) 
        {
            $team->isDeleted = true;
            $team->save();
            return response()->json(['success' => 'Team deleted successfully.']);
        } 
        else 
        {
            return response()->json(['error' => 'Team not found.'], 404);
        }
    }

    public function allTeam()
    {
        $allTeam = Team::where('isDeleted', '!=',true)->orderBy('created_at', 'desc')->get();
        return view('admin.allTeam', compact('allTeam'));
    }

    public function createNewGroup($id)
    {
        $members = Member::where('isDeleted', '!=', true)->orderBy('Name', 'asc')->get();
        $team = Team::where('_id', $id)->first();
        $assignedMemberIds = [];
        $groupNames = [];

        if (!empty($team->groupDetails)) 
        {
            foreach ($team->groupDetails as $group) 
            {
                $level = $group['grouplevel'] ?? ''; // Get level
                $name = $group['groupName'] ?? '';  // Get name

                if ($level && $name) {
                    $groupNames[$level] = $name; // Map level to group name
                }

                foreach ($group as $designation => $assignedMembers) 
                { 
                    if (is_array($assignedMembers)) 
                    {
                        foreach ($assignedMembers as $member) 
                        {
                            // $assignedMemberIds[] = $member['memberId']; 
                            if (isset($member['isActive']) && $member['isActive'] === "Yes") 
                            {
                                $assignedMemberIds[] = $member['memberId']; 
                            }
                        }
                    }
                }
            }
        }

        return view('admin.groupCreate', compact('members', 'team', 'id', 'assignedMemberIds', 'groupNames'));
    }
    public function insertNewGroup(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        // Retrieve form data
        $teamId = $request->teamId;
        $grpName = $request->grpName;
        $level = $request->level; // Group level (e.g., L1, L2)
        $designation = $request->dsgHd1; // e.g., "president"
        $memberIds = explode(',', $request->member_ids); 
        $memberNames = explode(',', $request->member_names); 
        $tenureStart = $request->startDate;
        $tenureEnd = $request->endDate;
        $tenure = $request->tenure;

        // Prepare the new group details for the designation
        $newDesignationDetails = [];
        foreach ($memberIds as $index => $memberId) {
            $newDesignationDetails[] = [
                'memberId' => $memberId,
                'name' => $memberNames[$index] ?? '',
                'isActive' => 'Yes',
            ];
        }

        // Retrieve the team
        $team = Team::where('_id', $teamId)->first();

        if (!$team) {
            return redirect()->back()->with('error', 'Team not found.');
        }

        // Get the current groupDetails or initialize an empty array
        $groupDetails = $team->groupDetails ?? [];

        // Check if the level already exists in groupDetails
        $levelFound = false;
        foreach ($groupDetails as &$group) {
            if ($group['grouplevel'] === $level) {
                $levelFound = true;
                // If the level exists, check if the designation exists
                if (!isset($group[$designation])) {
                    $group[$designation] = []; // Initialize designation array if not present
                }
                // Append new designation details
                $group[$designation] = array_merge($group[$designation], $newDesignationDetails);
            }
        }

        // If the level doesn't exist, add it as a new object
        if (!$levelFound) {
                $groupDetails[] = [
                    'groupName' => $grpName,
                    'grouplevel' => $level,
                    $designation => $newDesignationDetails,
                ];
        }

        // Update the team's groupDetails and save
        $team->groupDetails = $groupDetails;
        $team->save();


        // Insert into member_histories
        foreach ($newDesignationDetails as $member) {
            $memberId = $member['memberId'];
            $memberName = $member['name'];
        
            // Check if member history exists
            $memberHistory = MemberHistory::where('memberId', $memberId)->first();
        
            // Prepare new history entry
            $newHistory = [
                'teamId' => $teamId,
                'tenure' => $tenure,
                'groupName'=> $grpName,
                'grouplevel' => $level,
                'designation' => $designation,
                'positionStartDate' => $tenureStart,
                'positionEndDate' => $tenureEnd,
            ];
        
            if ($memberHistory) {
                // If member history exists, update the 'history' field by appending the new history
                $existingHistories = $memberHistory->history;
        
                // Check for duplicates (optional)
                $isDuplicate = false;
                foreach ($existingHistories as $history) {
                    if (
                        $history['grouplevel'] === $newHistory['grouplevel'] &&
                        $history['tenure'] === $newHistory['tenure'] &&
                        $history['designation'] === $newHistory['designation']
                    ) {
                        $isDuplicate = true;
                        break;
                    }
                }
        
                if (!$isDuplicate) 
                {
                    $existingHistories[] = $newHistory;
                }
        
                // Update the member history with the new 'history' array
                $memberHistory->history = $existingHistories;
                $memberHistory->save();
            } 
            else 
            {
                // If member history doesn't exist, create a new record
                $memberHistory = new MemberHistory;
                $memberHistory->memberId = $memberId;
                $memberHistory->memberName = $memberName;
                $memberHistory->history = [$newHistory]; // Initialize with the first history entry
                $memberHistory->save();
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Group created successfully.',
            'level' => $level // Keep level fixed for reload
        ]);
    }

    public function allGroup($id)
    {
        $team = Team::where('_id', $id)->first();
        $groups= $team->groupDetails;
        // echo "<pre>";
        // print_r($groups);die;

        return view('admin.allGroup', compact('groups','id'));
    }

    public function updateMemberStatus(Request $request) 
    {
        $teamId = $request->input('teamId');    // Team ID
        $memberId = $request->input('memberId'); // Member ID

        // Find the Team
        $team = Team::find($teamId);
        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Team not found.']);
        }

        $groupLevel = null;
        $designation = null;
        $isActiveFound = false; // Track if active member is found

        $groupDetails = $team->groupDetails;

        foreach ($groupDetails as $group) {
            $groupLevel = $group['grouplevel']; // Extract group level
            foreach ($group as $role => $members) {
                if (is_array($members)) { // Check for designations
                    foreach ($members as $member) {
                        if ($member['memberId'] === $memberId && $member['isActive'] === 'Yes') {
                            $designation = $role; // Extract designation
                            $isActiveFound = true;
                            break 2; // Exit both loops once found
                        }
                    }
                }
            }
            if ($isActiveFound) break; // Stop processing if active member is found
        }

        if (!$isActiveFound) {
            return response()->json(['success' => false, 'message' => 'Active member not found.']);
        }

        // Find Member History
        $historyRecord = MemberHistory::where('memberId', $memberId)->first();

        if (!$historyRecord) {
            return response()->json(['success' => false, 'message' => 'Member history not found.']);
        }

        // Update Position End Date in Member History
        $historyUpdated = false; // Track if history is updated
        $histories = $historyRecord->history;

        foreach ($histories as &$history) {
            if (
                isset($history['teamId']) && $history['teamId'] === $teamId &&
                isset($history['grouplevel']) && $history['grouplevel'] === $groupLevel &&
                isset($history['designation']) && $history['designation'] === $designation
            ) {
                // Update the position end date to today
                $history['positionEndDate'] = Carbon::now()->format('Ymd'); // Example: 20231223
                $historyUpdated = true;
                break;
            }
        }

        if ($historyUpdated) {
            $historyRecord->history = $histories; // Update history array
            $historyRecord->save(); // Save changes
        }

        // Update Member Status to "No" in Team
        $updated = false;
        foreach ($groupDetails as &$group) {
            foreach ($group as $role => &$members) {
                if (is_array($members)) {
                    foreach ($members as &$member) {
                        if ($member['memberId'] === $memberId) {
                            $member['isActive'] = 'No'; // Deactivate member
                            $updated = true;
                            break 2; // Exit both loops
                        }
                    }
                }
            }
        }

        if ($updated) {
            $team->groupDetails = $groupDetails; // Save updated group details
            $team->save();

            return response()->json(['success' => true, 'message' => 'Member status updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to update member status.']);
    }

    public function getGroups(Request $request)
    {
        $team = Team::find($request->teamId); // Fetch team by ID

        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $groups = collect($team->groupDetails)->map(function ($group) {
            $designations = [];
            foreach ($group as $key => $value) {
                // Check if key is a designation (e.g., 'Junior Developer', 'Senior Designer')
                if (is_array($value)) {
                    $designations[] = $key;
                }
            }
    
            return [
                'groupName' => $group['groupName'],
                'grouplevel' => $group['grouplevel'],
                'designations' => $designations // Collect all designations
            ];
        });

        return response()->json(['groups' => $groups]);
    }

    public function reassignMember(Request $request)
    {
        //  print_r($request->all());die;
        $teamId = $request->teamId;
        $memberId = $request->memberId;
        $groupLevel = $request->groupLevel;
        $designation = $request->designation;
        $name = $request->name;
        $groupName = $request->groupName;
        //  print_r($designation);die;

        // Find the team by ID
        $team = Team::find($teamId);
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $tenure = $team->tenure;
        $endDate = $team->endDate;

        // Extract previous groupLevel and designation
        $previousGroupLevel = null;
        $previousDesignation = null;
        $previousGroupName = null;

        // Extract the group details
        $groupDetails = $team->groupDetails;

        // Set previous isActive to 'No' in the current group
        foreach ($groupDetails as &$group) {
            foreach ($group as $role => &$members) {
                if (is_array($members)) {
                    foreach ($members as &$member) {
                        if ($member['memberId'] === $memberId && $member['isActive'] === 'Yes') {
                            $previousGroupLevel = $group['grouplevel']; // Previous level
                            $previousDesignation = $role; // Previous designation (e.g., Junior Developer)
                            $previousGroupName = $group['groupName'];
                        }
                        if ($member['memberId'] === $memberId) {
                            $member['isActive'] = 'No'; // Update previous status to 'No'
                        }
                    }
                }
            }
        }

        foreach ($groupDetails as &$group) {
            if ($group['grouplevel'] === $groupLevel) {
                $group[$designation][] = [
                    'memberId' => $memberId,
                    'name' => $name, 
                    'isActive' => 'Yes', 
                ];
            }
        }

        // Update the team with the modified group details
        $team->groupDetails = $groupDetails;
        $team->save();

        // Get today's date
        $today = Carbon::now()->format('Ymd'); // Format: YYYYMMDD

        // Find the member history by memberId
        $memberHistory = MemberHistory::where('memberId', $memberId)->first();
        
        if ($memberHistory) {
            $history = $memberHistory->history; // Get history array
            // print_r($history);die;

            // Update existing entry's positionEndDate
            foreach ($history as &$entry) {
                if (
                    $entry['teamId'] === $teamId &&
                    $entry['grouplevel'] === $previousGroupLevel && // Use previous group level
                    $entry['designation'] === $previousDesignation // Use previous designation
                ) {
                    $entry['positionEndDate'] = $today; // Close previous entry
                }
            }

            // Add a new entry inside the history array
            $history[] = [
                'teamId' => $teamId,
                'tenure' => $tenure,
                'groupName' => $groupName,
                'grouplevel' => $groupLevel,
                'designation' => $designation,
                'positionStartDate' => $today,
                'positionEndDate' => (string) $endDate, // No end date yet
            ];

            // Update the member history
            $memberHistory->history = $history; // Save the modified history
            $memberHistory->save();
        }

        return response()->json(['message' => 'Member reassigned successfully!']);
    }

    public function assignNewMembers($id, Request $request)
    {
        
        $groupName = $request->groupName;
        $grouplevel = $request->grouplevel;
        $desg = $request->designation;
        // print_r($designation);die;

        $members = Member::where('isDeleted', '!=', true)->orderBy('Name', 'asc')->get();
        $team = Team::where('_id', $id)->first();
        $assignedMemberIds = [];

        if (!empty($team->groupDetails)) 
        {
            foreach ($team->groupDetails as $group) 
            {
                foreach ($group as $designation => $assignedMembers) 
                { 
                    if (is_array($assignedMembers)) 
                    {
                        foreach ($assignedMembers as $member) 
                        {
                            // $assignedMemberIds[] = $member['memberId']; 
                            if (isset($member['isActive']) && $member['isActive'] === "Yes") 
                            {
                                $assignedMemberIds[] = $member['memberId']; 
                            }
                        }
                    }
                }
            }
        }

        return view('admin.groupAssignNewMembers', compact('members', 'team', 'id', 'assignedMemberIds','groupName', 'grouplevel', 'desg'));

    }

    public function downloadGroups($id) 
    {
        try {
            // Fetch team and groups
            $team = Team::where('_id', $id)->first();
    
            if (!$team) {
                return redirect()->back()->with('error', 'Team not found!');
            }
    
            $groups = $team->groupDetails;
    
            // Create Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // Set Header Row
            $sheet->setCellValue('A1', 'Group Name');
            $sheet->setCellValue('B1', 'Group Level');
            $sheet->setCellValue('C1', 'Designation');
            $sheet->setCellValue('D1', 'Assigned Members');
    
            // Fill Data
            $row = 2; // Start from 2nd row
            foreach ($groups as $group) {
                foreach ($group as $designation => $members) {
                    if (is_iterable($members)) {
                        $sheet->setCellValue('A' . $row, $group['groupName']);
                        $sheet->setCellValue('B' . $row, $group['grouplevel']);
                        $sheet->setCellValue('C' . $row, ucfirst($designation));
                        foreach ($members as $member) {
                            // dd($member); 
                        
                            // $assignedMembers = collect($members)
                            //     ->where('isActive', 'Yes') // Filter active members
                            //     ->pluck('name') // Get member names
                            //     ->implode(', '); // Separate names with commas
        
                            // // Write Data
                            if($member['isActive']==="Yes"){
                                $sheet->setCellValue('D' . $row, $member['name']);
            
                                $row++;
                            }
                        }
                    }
                }
            }
    
            // Generate Excel File
            $fileName = 'Groups_' . $team->teamName .'.xlsx';
            $writer = new Xlsx($spreadsheet);
    
            // Streamed Response
            return new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
                    'Cache-Control' => 'max-age=0',
                ]
            );
    
        } catch (WriterException $e) {
            return redirect()->back()->with('error', 'Error creating Excel file!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function memberPositionDetails()
    {
        $memberHistory=MemberHistory::paginate(20);
        return view('admin.userHistoryDetails', compact('memberHistory'));
    }

    public function downloadPositionHistory()
    {
        $members = MemberHistory::all(); 

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Member Name']; 
        $maxHistory = 0; 

        foreach ($members as $member) {
            if (!empty($member->history) && is_array($member->history)) {
                $historyCount = count($member->history);
                $maxHistory = max($maxHistory, $historyCount); 
            }
        }

        for ($i = 1; $i <= $maxHistory; $i++) {
            $headers[] = "Team Name $i";
            $headers[] = "Tenure $i";
            $headers[] = "Group Name $i";
            $headers[] = "Group Level $i";
            $headers[] = "Designation $i";
            $headers[] = "Start Date $i";
            $headers[] = "End Date $i";
        }

        $col = 1; 
        foreach ($headers as $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . '1'; 
            $sheet->setCellValue($cell, $header);
            $col++;
        }

        $row = 2; 
        foreach ($members as $member) 
        {
            $col = 1; 
            $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $member->memberName);

            if (!empty($member->history) && is_array($member->history)) 
            {
                foreach ($member->history as $history) 
                {

                    $team = Team::where('_id', $history['teamId'])->first();

                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $team ? $team->teamName : 'N/A');
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $history['tenure']);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $history['groupName']);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $history['grouplevel']);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, $history['designation']);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, date('d-m-Y', strtotime($history['positionStartDate'])));
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++) . $row, date('d-m-Y', strtotime($history['positionEndDate'])));
                }
            }
            $row++; 
        }

        $fileName = 'Position_History.xlsx';
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

}
