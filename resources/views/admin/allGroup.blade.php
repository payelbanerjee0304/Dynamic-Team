@extends('layout.adminapp')
@section('content')
<style>
    .grpModalDes
    {
        font-size:13px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="otr mmbr_pg_ottr">
    <div class="container new">
      <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list cc-nws">
            <div class="heading new">

            <a href="{{ route('admin.allTeam') }}"><i class="fa fa-long-arrow-left"></i></a>
                <h1>All group details for {{ $teamName }}</h1>
            </div>
            <div class="c-nws">
                <a href="{{ route('admin.createNewGroup', $id) }}" class="mmbr_list_right_anch">Create Group</a>&nbsp;
                <a href="{{ route('admin.downloadGroups', $id) }}" class="mmbr_list_right_anch">Download Format</a>&nbsp;
                <a href="{{ route('admin.importMembersGroupPage', $id) }}" class="mmbr_list_right_anch">Import Members</a>
            </div>
        </div>
        <div id="tableData" class="admn_al_grp">
            <div class="all-team">
                <ul class="table">
                    <!-- Table Header -->
                    <li class="table-row header">
                        <div class="table-cell">Group Name</div>
                        <div class="table-cell">Group Level</div>
                        <div class="table-cell">Designation</div>
                        <div class="table-cell">Assigned Members</div>
                        <div class="table-cell">Max Assigned Members</div>
                        <div class="table-cell">Assign New</div>
                    </li>
        
                    <!-- Table Body -->
                    @if (collect($groups)->isNotEmpty())
                        @foreach ($groups as $group)
                            @foreach ($group as $designation => $members)
                                @if ($designation !== 'maxAssignedMembers')
                                    @if (is_iterable($members)) 
                                        <li class="table-row">
                                            <!-- Group Level -->
                                            <div class="table-cell">{{ $group['groupName'] }}</div>
                                            <div class="table-cell">{{ $group['grouplevel'] }}</div>
            
                                            <!-- Designation -->
                                            <div class="table-cell">{{ ucfirst($designation) }}</div>
            
                                            <!-- Assigned Members -->
                                            <div class="table-cell mem_list">
                                                {{-- <a href="" class="new_page"><span><i class="fa fa-book"></i></span></a> --}}
                                                <ul class="members-list">
                                                    @foreach ($members as $member)
                                                        @if ($member['isActive'] === 'Yes')
                                                            {{-- <li>{{ $member['name'] }} <br>{{ $member['isActive'] === 'Yes' ? '(active)' : '' }}  --}}
                                                            <li>{{ $member['name'] }} 
                                                                <a href="javascript:void(0);" class="editMember" data-team-id="{{ $id }}" data-id="{{ $member['memberId'] }}" data-name="{{ $member['name'] }}" data-status="{{ $member['isActive'] }}" data-designation="{{ $designation }} "data-max-assigned="{{ $group['maxAssignedMembers'][$designation] ?? 'N/A' }}" data-already-assigned="{{ count($members) }}">
                                                                    <i class="fa-regular fa-pen-to-square" style="color: #e13333" ></i>
                                                                </a> 
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="table-cell">
                                                {{ $group['maxAssignedMembers'][$designation] ?? 'N/A' }}
                                            </div>
                                            <div class="table-cell">
                                                <a href="{{ route('admin.assignNewMembers', [
                                                            'id' => $id,
                                                            'groupName' => $group['groupName'],
                                                            'grouplevel' => $group['grouplevel'],
                                                            'designation' => $designation,
                                                            'maxAssignedMembers' => $group['maxAssignedMembers'][$designation] ?? 0,
                                                            'alreadyAssignedMembers' => count($members),
                                                            // 'members' => json_encode($members) // Encode members as JSON
                                                        ]) }}" class="new_page">
                                                    <span><i class="fa fa-book"></i></span>
                                                </a>
                                            </div>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <li class="table-row">
                            <div class="table-cell" colspan="3">No data available</div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        
      </div>
    </div>
</div>

{{-- modal part --}}
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added modal-sm and modal-dialog-centered -->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title" id="editMemberModalLabel">Edit Member Status</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center"> <!-- Text aligned to center -->
                <h3><strong>Member Name:</strong></h3>
                <h3 id="modalMemberName" class="mb-3"></h3> <!-- Member Name -->
                <h3><strong>Status:</strong> <span id="modalMemberStatus"></span></h3> <!-- Display status -->
                <form id="updateMemberForm">
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="statusValue" id="statusValue" value="No">
                    <input type="hidden" id="modalHiddenMemberId" name="memberId">
                    <input type="hidden" id="modalHiddenTeamId" name="teamId">
                    <input type="hidden" id="modalHiddenCurrentDesignation" name="currentDesignation">
                    <input type="hidden" id="modalHiddenMaxAssignedMembers" name="modalHiddenMaxAssignedMembers">
                    <input type="hidden" id="modalHiddenAlreadyAssignedMembers" name="modalHiddenAlreadyAssignedMembers">

                    <!-- Submit Button -->
                    
                    <button type="submit" class="btn btn-warning btn-lg fs-3 mb-3" id="Inactive">Inactive</button> <!-- Bigger button -->
                </form>
                <button id="assignToAnother" class="btn btn-info btn-lg fs-3">Assign to Another</button>

                <div id="assignSection" class="mt-4 d-none">
                    <select id="groupSelect" class="form-select mb-3 grpModalDes">
                        <option value="">Select Group</option>
                    </select>

                    <select id="designationSelect" class="form-select mb-3 grpModalDes">
                        <option value="">Select Designation</option>
                    </select>

                    <button id="assignMemberBtn" class="btn btn-warning fs-3">Reassign</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('customJs')
<script>

    $(document).ready(function () {
        // Open modal and populate values
        $('.editMember').click(function () {
            let teamId = $(this).data('team-id');
            let memberId = $(this).data('id');
            let memberName = $(this).data('name');
            let status = $(this).data('status');
            let currentDesignation = $(this).data('designation');
            let maxAssignedMembers = $(this).data('max-assigned');
            let alreadyAssignedMembers = $(this).data('already-assigned');
            // console.log(alreadyAssignedMembers);

            let statusText = (status.toLowerCase() === 'yes') ? 'Active' : 'Inactive';

            // Populate modal fields
            $('#modalMemberId').text(memberId);
            $('#modalMemberName').text(memberName);
            $('#modalMemberStatus').text(statusText); 

            $('#modalHiddenTeamId').val(teamId);
            $('#modalHiddenMemberId').val(memberId);
            $('#modalHiddenCurrentDesignation').val(currentDesignation);
            $('#modalHiddenMaxAssignedMembers').val(maxAssignedMembers);
            $('#modalHiddenAlreadyAssignedMembers').val(alreadyAssignedMembers);

            // Show modal
            $('#editMemberModal').modal('show');
        });

        // Submit the form
        $('#updateMemberForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let teamId = $('#modalHiddenTeamId').val();
            let memberId = $('#modalHiddenMemberId').val();
            let statusValue = $('#statusValue').val();
            // console.log(statusValue);
            // console.log(teamId);
            // console.log(memberId);

            // AJAX request to update the member status
            $.ajax({
                url: '{{ route('admin.updateMemberStatus') }}', // Replace with your route
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    teamId: teamId,
                    memberId: memberId,
                    statusValue: statusValue,
                },
                success: function (response) {
                    console.log(response);
                    alert("Status updated successfully!");
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (error) {
                    alert('Failed to update status.');
                }
            });
        });

        // Show Group and Designation Dropdowns
        $('#assignToAnother').click(function () {
            $(this).hide();
            $('#Inactive').hide();
            let teamId = $('#modalHiddenTeamId').val();
            let currentDesignation = $('#modalHiddenCurrentDesignation').val();
            let memberId = $('#modalHiddenMemberId').val();
            // console.log(memberId);

            // Fetch groups and designations via AJAX
            $.ajax({
                url: '{{ route('admin.getGroups') }}', 
                type: 'GET',
                data: { 
                    teamId: teamId,
                    currentDesignation:currentDesignation,
                    memberId: memberId,
                },
                success: function (response) {
                    // Populate Group Dropdown
                    $('#groupSelect').empty().append('<option value="">Select Group level</option>');
                    $('#designationSelect').empty().append('<option value="">Select Designation</option>'); // Clear designations

                    response.groups.forEach(function (group) {
                        // Append group level with group name
                        let optionText = group.grouplevel + ' (' + group.groupName + ')';
                        $('#groupSelect').append('<option value="' + group.grouplevel + '" data-designations=\'' + JSON.stringify(group.designations) + '\'>' + optionText + '</option>');
                    });

                    $('#assignSection').removeClass('d-none'); // Show dropdowns
                },
                error: function () {
                    alert('Failed to load groups.');
                }
            });
        });

        // Populate Designation Dropdown on Group Change
        $('#groupSelect').change(function () {
            let designations = JSON.parse($('#groupSelect option:selected').attr('data-designations') || '[]');
            let currentDesignation = $('#modalHiddenCurrentDesignation').val();
            let maxAssignedMembers = $('#modalHiddenMaxAssignedMembers').val();
            // console.log(maxAssignedMembers);

            $('#designationSelect').empty().append('<option value="">Select Designation</option>');

            designations.forEach(function (designation) {
                if (designation !== currentDesignation) {
                    $('#designationSelect').append('<option value="' + designation + '">' + designation + '</option>');
                }
            });
        });


        // Reassign Member
        $('#assignMemberBtn').click(function () {
            let teamId = $('#modalHiddenTeamId').val();
            let memberId = $('#modalHiddenMemberId').val();
            let groupLevel = $('#groupSelect').val();
            let designation = $('#designationSelect').val();
            let memberName = $('#modalMemberName').text();
            let groupName = $('#groupSelect option:selected').text().split('(')[1].replace(')', '').trim();

            // console.log(memberName);
            // console.log(teamId);
            // console.log(memberId);
            // console.log(groupLevel);
            // console.log(designation);
            // console.log(groupName);

            if (!groupLevel || !designation) {
                alert('Please select both group and designation.');
                return;
            }

            $.ajax({
                url: '{{ route('admin.reassignMember') }}', // Replace with your route
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    teamId: teamId,
                    memberId: memberId,
                    groupLevel: groupLevel,
                    designation: designation,
                    name: memberName,
                    groupName: groupName,
                },
                success: function (response) {
                    alert('Member reassigned successfully!');
                    // console.log(response);
                    location.reload();
                },
                error: function () {
                    alert('Failed to reassign member.');
                }
            });
        });
    });

</script>
@endsection