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
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $adminId = Session::get('admin_id');
        // print_r($adminId);die;

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
        $team->adminId = $adminId;

        $team->save();

        return redirect('admin/all-team')->with('success', 'Team inserted successfully.');
    }

    public function editTeamDetails($id)
    {
        $adminId = Session::get('admin_id');

        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();

        return view('admin.teamEdit', compact('id','team'));
    }

    public function updateTeamDetails(Request $request)
    {
        $adminId = Session::get('admin_id');

        // echo "<pre>";
        // print_r($request->all());die;
        $formData = $request->all();
        
        // print_r($team);die;
        $tenure=$formData['dateRange'];
        $tenureDates = explode(' to ', $tenure);
        $startDate = Carbon::createFromFormat('d-m-Y', $tenureDates[0])->format('Ymd');
        $endDate = Carbon::createFromFormat('d-m-Y', $tenureDates[1])->format('Ymd');

        $team = Team::where('adminId','=',$adminId)->find($formData['teamId']);

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
        $adminId = Session::get('admin_id');

        $team = Team::where('adminId','=',$adminId)->find($request->id);
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
        $adminId = Session::get('admin_id');

        $allTeam = Team::where('adminId','=',$adminId)->where('isDeleted', '!=',true)->orderBy('created_at', 'desc')->get();
        return view('admin.allTeam', compact('allTeam'));
    }

    public function createNewGroup($id)
    {
        $adminId = Session::get('admin_id');

        $members = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)->orderBy('Name', 'asc')->get();
        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();
        $assignedMemberIds = [];
        $groupNames = [];

        if (!empty($team->groupDetails)) 
        {
            foreach ($team->groupDetails as $group) 
            {
                $level = $group['grouplevel'] ?? ''; // Get level
                $name = $group['groupName'] ?? '';  // Get name

                if ($level && $name) 
                {
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
        $adminId = Session::get('admin_id');

        // echo "<pre>";
        // print_r($request->all());die;
        // Retrieve form data
        $teamId = $request->teamId;
        $grpName = $request->grpName;
        $level = $request->level; // Group level (e.g., L1, L2)
        $designation = $request->dsgHd1; // e.g., "president"
        $nosOfMemberAssigned = $request->nosOfMemberAssigned; // e.g., "president"
        $memberIds = $request->member_ids ? explode(',', $request->member_ids) : []; 
        $memberNames = $request->member_names ? explode(',', $request->member_names) : [];
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
        $team = Team::where('adminId','=',$adminId)->where('_id', $teamId)->first();

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

                if (!isset($group['maxAssignedMembers'])) {
                    $group['maxAssignedMembers'] = [];
                }

                // Assign maxAssignedMembers for the specific designation
                $group['maxAssignedMembers'][$designation] = $nosOfMemberAssigned;

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
                    'maxAssignedMembers' => [
                        $designation => $nosOfMemberAssigned, // Store designation-specific count
                    ],
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
                'positionStartDate' => (int) $tenureStart,
                'positionEndDate' => (int) $tenureEnd,
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
                $memberHistory->adminId = $adminId; 
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
        $adminId = Session::get('admin_id');

        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();
        $groups= $team->groupDetails;
        // echo "<pre>";
        // print_r($groups);die;
        $teamName= $team->teamName;

        return view('admin.allGroup', compact('groups','id','teamName'));
    }

    public function updateMemberStatus(Request $request)
    {
        $adminId = Session::get('admin_id');

        $teamId = $request->input('teamId');    // Team ID
        $memberId = $request->input('memberId'); // Member ID to be removed

        // Find the Team by the provided team ID
        $team = Team::where('adminId','=',$adminId)->find($teamId);
        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Team not found.']);
        }

        $groupLevel = null;
        $designation = null;
        // Retrieve the groupDetails from the team
        $groupDetails = $team->groupDetails;

        // Flag to check if the member was removed
        $removed = false;

        
        // Loop through each group in groupDetails to find and remove the member
        foreach ($groupDetails as &$group) {
            // Skip the 'maxAssignedMembers' field by using it but not doing anything with it
            if (isset($group['maxAssignedMembers'])) {
                // You don't need to process or update this field, so we just skip it
                // No operation performed on maxAssignedMembers
            }
    
            // Loop through each role within the group (e.g., senior developer, junior developer)
            foreach ($group as $role => &$members) {
                // Ensure that maxAssignedMembers is not considered, so check for member arrays
                if ($role !== 'maxAssignedMembers' && is_array($members)) {
                    // Loop through the members and find the member with the given memberId
                    foreach ($members as $index => &$member) {
                        // Check if memberId matches and is active
                        if ($member['memberId'] === $memberId && $member['isActive'] === 'Yes') {
                            // Remove the member from the role's member list
                            unset($members[$index]);
                            $removed = true;
                            break 3; // Exit all loops once the member is found and removed
                        }
                    }
                }
            }
        }

        // If the member was successfully removed, update and save the team
        if ($removed) {
            $team->groupDetails = $groupDetails; // Update the group details with the modified list
            $team->save(); // Save the changes to the team model

            // Now, handle MemberHistory
        $historyRecord = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)->first();
        if ($historyRecord) {
            // Update the positionEndDate for the history record
            $histories = $historyRecord->history;
            $historyUpdated = false;

            foreach ($histories as &$history) {
                if (isset($history['teamId']) && $history['teamId'] === $teamId) {
                    // Update the positionEndDate
                    $history['positionEndDate'] = (int) Carbon::now()->format('Ymd'); // Set to today's date
                    $historyUpdated = true;
                    break; // Exit the loop once the record is updated
                }
            }

            if ($historyUpdated) {
                $historyRecord->history = $histories;
                $historyRecord->save(); // Save the changes to the MemberHistory
            }
        }

        return response()->json(['success' => true, 'message' => 'Member removed successfully and history updated.']);
        }

        // If no member was found or removed, return a failure response
        return response()->json(['success' => false, 'message' => 'Member not found or already inactive.']);
    }

    public function getGroups(Request $request)
    {
        $adminId = Session::get('admin_id');

        $team = Team::where('adminId','=',$adminId)->find($request->teamId); // Fetch team by ID
        $memberId = $request->memberId; // Member ID
        $currentDesignation = $request->currentDesignation; // Current designation of the person

        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        // Fetch member history
        $memberHistory = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)->first();

        $excludedDesignations = [];
        if ($memberHistory) {
            foreach ($memberHistory->history as $history) {
                // Match by both teamId and group level
                if ($history['teamId'] === $request->teamId) {
                    $excludedDesignations[$history['grouplevel']][] = $history['designation'];
                }
            }
        }

        // Process groups and exclude designations based on member history
        $groups = collect($team->groupDetails)->map(function ($group) use ($currentDesignation, $excludedDesignations) {
            $designations = [];

            foreach ($group['maxAssignedMembers'] as $designation => $maxCount) {
                $assignedCount = count($group[$designation]);

                // Exclude designations if already held in history for this level or matches the current designation
                $groupLevel = $group['grouplevel'];
                if ($assignedCount < $maxCount 
                    && (!isset($excludedDesignations[$groupLevel]) || !in_array($designation, $excludedDesignations[$groupLevel]))
                    && $designation !== $currentDesignation) {
                    $designations[] = $designation;
                }
            }

            return [
                'groupName' => $group['groupName'],
                'grouplevel' => $group['grouplevel'],
                'designations' => $designations // Collect eligible designations
            ];
        });

        return response()->json(['groups' => $groups]);
    }

    public function reassignMember(Request $request)
    {
        $adminId = Session::get('admin_id');

        $teamId = $request->teamId; // Team ID
        $memberId = $request->memberId; // Member ID
        $groupLevel = $request->groupLevel; // New group level
        $designation = $request->designation; // New designation
        $name = $request->name; // Member name
        $groupName = $request->groupName; // New group name

        // Find the team by ID
        $team = Team::where('adminId','=',$adminId)->find($teamId);
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $tenure = $team->tenure;
        $endDate = $team->endDate;

        // Extract the group details
        $groupDetails = $team->groupDetails;

        // Variables to store the previous assignment
        $previousGroupLevel = null;
        $previousDesignation = null;
        $previousGroupName = null;

        // Remove the member from the previous designation
        foreach ($groupDetails as &$group) {
            foreach ($group as $role => &$members) {
                // Ignore maxAssignedMembers
                if ($role === 'maxAssignedMembers') {
                    continue;
                }

                // Find and remove the member from the previous group
                if (is_array($members)) {
                    foreach ($members as $index => $member) {
                        if ($member['memberId'] === $memberId) {
                            $previousGroupLevel = $group['grouplevel']; // Store previous group level
                            $previousDesignation = $role; // Store previous designation
                            $previousGroupName = $group['groupName']; // Store previous group name
                            unset($members[$index]); // Remove member
                        }
                    }
                    // Re-index array after removing the member
                    $members = array_values($members);
                }
            }
        }

        // Add the member to the new designation
        foreach ($groupDetails as &$group) {
            if ($group['grouplevel'] === $groupLevel) {
                $group[$designation][] = [
                    'memberId' => $memberId,
                    'name' => $name,
                    'isActive' => 'Yes', // New assignment
                ];
            }
        }

        // Update the team with modified group details
        $team->groupDetails = $groupDetails;
        $team->save();

        // Update the MemberHistory
        $today = Carbon::now()->format('Ymd'); // Current date
        $memberHistory = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)->first();

        if ($memberHistory) {
            $history = $memberHistory->history;

            // Update positionEndDate for the previous entry
            foreach ($history as &$entry) {
                if (
                    $entry['teamId'] === $teamId &&
                    $entry['grouplevel'] === $previousGroupLevel &&
                    $entry['designation'] === $previousDesignation
                ) {
                    $entry['positionEndDate'] = (int) $today; // Close the previous position
                }
            }

            // Add a new entry for the reassignment
            $history[] = [
                'teamId' => $teamId,
                'tenure' => $tenure,
                'groupName' => $groupName,
                'grouplevel' => $groupLevel,
                'designation' => $designation,
                'positionStartDate' => (int) $today,
                'positionEndDate' => $endDate, // Keep the original end date
            ];

            // Save the updated history
            $memberHistory->history = $history;
            $memberHistory->save();
        }

        return response()->json(['message' => 'Member reassigned successfully!']);
    }

    public function assignNewMembers($id, Request $request)
    {
        $adminId = Session::get('admin_id');

        $groupName = $request->groupName;
        $grouplevel = $request->grouplevel;
        $desg = $request->designation;
        $maxAssignedMembers = $request->maxAssignedMembers;
        $alreadyAssignedCount=$request->alreadyAssignedMembers;
        // print_r($alreadyAssignedCount);die;

        $members = Member::where('adminId','=',$adminId)->where('isDeleted', '!=', true)->orderBy('Name', 'asc')->get();
        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();
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

        // Fetch previously assigned members from memberHistory
        $historyAssignedMemberIds = MemberHistory::where('history', 'elemMatch', [
            'teamId' => $id,
            'grouplevel' => $grouplevel,
            'designation' => $desg
        ])->pluck('memberId')->toArray();

        // print_r($historyAssignedMemberIds);die;

        // Merge both arrays and remove duplicates
        $disabledMemberIds = array_unique(array_merge($assignedMemberIds, $historyAssignedMemberIds));

        return view('admin.groupAssignNewMembers', compact('members', 'team', 'id', 'assignedMemberIds','groupName', 'grouplevel', 'desg','maxAssignedMembers', 'alreadyAssignedCount', 'disabledMemberIds'));

    }

    public function downloadGroups($id)
    {
        $adminId = Session::get('admin_id');

        try {
            // Fetch team and groups
            $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();

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
            $sheet->setCellValue('E1', 'Mobile');

            // Fill Data
            $row = 2; // Start from 2nd row
            foreach ($groups as $group) {
                $groupName = $group['groupName'];
                $groupLevel = $group['grouplevel'];

                foreach ($group['maxAssignedMembers'] as $designation => $maxCount) {
                    // Check if designation key exists in the group
                    $members = isset($group[$designation]) ? $group[$designation] : [];

                    // Filter active members
                    $activeMembers = array_filter($members, function ($member) {
                        return $member['isActive'] === "Yes";
                    });

                    $filledSlots = 0;

                    // Write members
                    foreach ($activeMembers as $member) {
                        $memberDetails = Member::where('_id', $member['memberId'])->first(); // Fetch member details
                        $mobile = $memberDetails ? $memberDetails->Mobile : ''; // Get mobile or set to blank if not found


                        $sheet->setCellValue('A' . $row, $groupName);
                        $sheet->setCellValue('B' . $row, $groupLevel);
                        $sheet->setCellValue('C' . $row, ucfirst($designation));
                        $sheet->setCellValue('D' . $row, $member['name']);
                        $sheet->setCellValue('E' . $row, $mobile);
                        $row++;
                        $filledSlots++;
                    }

                    // Fill empty rows for unfilled slots
                    while ($filledSlots < $maxCount) {
                        $sheet->setCellValue('A' . $row, $groupName);
                        $sheet->setCellValue('B' . $row, $groupLevel);
                        $sheet->setCellValue('C' . $row, ucfirst($designation));
                        $sheet->setCellValue('D' . $row, '');
                        $row++;
                        $filledSlots++;
                    }
                }
            }

            $fileName = 'Groups_' . $team->teamName . '.xlsx';
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
        $adminId = Session::get('admin_id');

        $memberHistory=MemberHistory::where('adminId','=',$adminId)->paginate(20);
        return view('admin.userHistoryDetails', compact('memberHistory'));
    }

    public function downloadPositionHistory()
    {
        $adminId = Session::get('admin_id');

        $members = MemberHistory::where('adminId','=',$adminId)->get(); 

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

    public function importMembersGroupPage($id)
    {
        $adminId = Session::get('admin_id');

        // Fetch team details for context (optional)
        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();

        if (!$team) {
            return redirect()->back()->with('error', 'Team not found!');
        }

        return view('admin.importGroupMembers', compact('team', 'id'));
    }

    public function importGroups(Request $request, $id)
    {
        $adminId = Session::get('admin_id');
        // echo $adminId;die;

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true); // Convert sheet to array
        
            // Fetch the team
            $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();
        
            if (!$team) {
                return redirect()->back()->with('error', 'Team not found!');
            }
        
            $groupDetails = is_array($team->groupDetails) ? $team->groupDetails : json_decode($team->groupDetails, true);
        
            // Process rows (skip header row)
            foreach ($rows as $index => $row) {
                if ($index == 1) continue; // Skip header row

                $mobile = trim($row['E']);
                if (!$mobile) continue; // Skip rows without a mobile number

                $member = Member::where('Mobile', (int)$mobile)->orWhere('Mobile', (string)$mobile)->where('adminId','=',$adminId)->first();
                if (!$member) {
                    continue; // Skip if member not found
                }

                $memberId = $member->_id;
                $fullName = $member->Name 
                    . ($member->Middle_Name !== "" && $member->Middle_Name !== null ? ' ' . $member->Middle_Name : '') 
                    . ($member->Surname !== "" && $member->Surname !== null ? ' ' . $member->Surname : '');
                $groupName = trim($row['A']);
                $groupLevel = trim($row['B']);
                $designation = strtolower(trim($row['C']));

                if (empty($groupName) || empty($groupLevel) || empty($designation)) {
                    continue;
                }

                $groupIndex = null;
                foreach ($groupDetails as $key => $group) {
                    if ($group['groupName'] == $groupName && $group['grouplevel'] == $groupLevel) {
                        $groupIndex = $key;
                        break;
                    }
                }

                if ($groupIndex === null) continue;

                $assignedMembers = $groupDetails[$groupIndex][$designation] ?? [];
                $existingMemberIds = array_column($assignedMembers, 'memberId');
                if (in_array($memberId, $existingMemberIds)) continue;

                $maxAssigned = (int)$groupDetails[$groupIndex]['maxAssignedMembers'][$designation] ?? 0;
                if (count($assignedMembers) >= $maxAssigned) continue;

                // Check MemberHistory for the same team, group level, and designation
                $existingHistory = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)
                    ->where('history', 'elemMatch', [
                        'teamId' => $team->_id,
                        'grouplevel' => $groupLevel,
                        'designation' => $designation,
                    ])
                    ->exists();

                if ($existingHistory) {
                    // Skip this member if they are already assigned in MemberHistory
                    continue;
                }

                // At this point, we are sure the member is being assigned to the group
                // Update MemberHistory here
                $memberHistory = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)->first();

                $newHistory = [
                    'teamId' => $team->_id,
                    'tenure' => $team->tenure,
                    'groupName' => $groupName,
                    'grouplevel' => $groupLevel,
                    'designation' => $designation,
                    'positionStartDate' => $team->startDate > (int) Carbon::now()->format('Ymd') ? $team->startDate : (int) Carbon::now()->format('Ymd'),
                    'positionEndDate' => $team->endDate,
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

                    if (!$isDuplicate) {
                        $existingHistories[] = $newHistory;
                    }

                    // Update the member history with the new 'history' array
                    $memberHistory->history = $existingHistories;
                    $memberHistory->save();
                } else {
                    // If member history doesn't exist, create a new record
                    $memberHistory = new MemberHistory;
                    $memberHistory->memberId = $memberId;
                    $memberHistory->memberName = $fullName;
                    $memberHistory->history = [$newHistory]; // Initialize with the first history entry
                    $memberHistory->adminId = $adminId;
                    $memberHistory->save();
                }

                // Add the member to the group
                $newMemberEntry = [
                    'memberId' => $memberId,
                    'name' => $fullName,
                    'isActive' => 'Yes',
                ];

                $groupDetails[$groupIndex][$designation][] = $newMemberEntry;
            }

            // Update groupDetails in the team document
            $team->groupDetails = $groupDetails;
            $team->save();

        
            return redirect()->back()->with('success', 'Group details updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        
    }

    public function teamClonePage($id)
    {
        $adminId = Session::get('admin_id');

        $team = Team::where('adminId','=',$adminId)->where('_id', $id)->first();

        return view('admin.teamClonePage', compact('id','team'));
    }

    public function cloneTeam(Request $request)
    {
        $adminId = Session::get('admin_id');

        $originalTeamId = $request->input('teamId');
        $originalTeam = Team::where('adminId','=',$adminId)->where('_id', $originalTeamId)->first();

        if (!$originalTeam) {
            return redirect()->back()->withErrors(['error' => 'Original team not found.']);
        }

        // Clone the groupDetails from the original team
        $groupDetails = $originalTeam->groupDetails ?? [];

        // Parse the tenure dates
        $tenure = $request->input('dateRange');
        $tenureDates = explode(' to ', $tenure);
        $startDate = Carbon::createFromFormat('d-m-Y', $tenureDates[0])->format('Ymd');
        $endDate = Carbon::createFromFormat('d-m-Y', $tenureDates[1])->format('Ymd');

        // Create a new team
        $newTeam = new Team();
        $newTeam->teamName = $request->input('team') ?? '';
        $newTeam->tenure = $tenure ?? '';
        $newTeam->startDate = (int) $startDate ?? '';
        $newTeam->endDate = (int) $endDate ?? '';
        $newTeam->isActive = true;
        $newTeam->clonedFromTeamId = $originalTeamId;
        $newTeam->groupDetails = $groupDetails;
        $newTeam->save();

        // Update the memberHistory table
        foreach ($groupDetails as $group) {
            foreach ($group as $designation => $members) {
                // Skip non-member arrays like `maxAssignedMembers`
                if (!is_array($members)) {
                    continue;
                }

                foreach ($members as $member) {
                    $memberId = $member['memberId'] ?? null;
                    $memberName = $member['name'] ?? null;

                    if ($memberId) {
                        // Fetch or create member history
                        $memberHistory = MemberHistory::where('adminId','=',$adminId)->where('memberId', $memberId)->first();

                        if (!$memberHistory) {
                            // If no record exists, create a new one
                            $memberHistory = new MemberHistory();
                            $memberHistory->memberId = $memberId;
                            $memberHistory->memberName = $memberName;
                            $memberHistory->history = []; // Initialize history as an empty array
                            $memberHistory->adminId = $adminId;
                        }

                        // Add the new history entry
                        $existingHistory = $memberHistory->history ?? [];
                        $newHistory = [
                            'teamId' => (string) $newTeam->_id,
                            'tenure' => $tenure,
                            'groupName' => $group['groupName'] ?? '',
                            'grouplevel' => $group['grouplevel'] ?? '',
                            'designation' => $designation,
                            'positionStartDate' => (int) $startDate,
                            'positionEndDate' => (int) $endDate,
                        ];
                        $existingHistory[] = $newHistory;

                        // Reassign and save
                        $memberHistory->history = $existingHistory;
                        $memberHistory->save();
                    }
                }
            }
        }

        return redirect()->route('admin.allTeam')->with('success', 'Team cloned successfully, and member history updated.');
    }



}
