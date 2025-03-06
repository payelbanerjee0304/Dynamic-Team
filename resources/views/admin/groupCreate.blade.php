@extends('layout.adminapp')


@section('content')
<style>
    .swal2-confirm.swal2-styled{
        background-color: rgb(47, 97, 47);
    }
    .swal2-cancel.swal2-styled{
        background-color: #ff0000;
    }
</style>
<div class="otr">
    <div class="container">
      <div class="south_jst editor">
        <div class="mul_form">
            <div class="multi_top_dir">Create Group</div>
                <form method="POST" id="dynamic-form" action="{{ route('admin.insertNewGroup') }}" >
                    @csrf
                    <input type="hidden" name="teamId" id="teamId" value="{{ $id }}">
                    <div class="frm_cnt" id="frm_cnt1">
                        <h1>Tenure: {{ $team->tenure }}</h1>
                        <input type="hidden" name="tenure" id="tenure" value="{{ $team->tenure }}">
                        <input type="hidden" name="startDate" id="startDate" value="{{ $team->startDate }}">
                        <input type="hidden" name="endDate" id="endDate" value="{{ $team->endDate }}">
                        <div class="frm_row">
                            <label>Group Level</label>
                            <select name="level" id="level"  placeholder="Enter Level">
                                <option value="">Select</option>
                                <option value="L1">Level 1</option>
                                <option value="L2">Level 2</option>
                                <option value="L3">Level 3</option>
                                <option value="L4">Level 4</option>
                                <option value="L5">Level 5</option>
                                <option value="L6">Level 6</option>
                            </select>
                            <small class="error-message" id="level_error"></small>
                        </div>
                        <div class="frm_row">
                            <label> Group Name</label>
                            <input type="text" name="grpName" id="grpName" placeholder="Enter Name">
                            <small class="error-message" id="grpName_error"></small>
                        </div>
                        <div class="designtnAssn" id="designtnAssn">
                            <div class="frm_row">
                                <label>
                                    <input type="text" name="dsgHd1" id="dsgHd1" placeholder="Enter Designation" oninput="formatInput(this)"><br>
                                    <small class="error-message" id="dsgHd1_error"></small>
                                </label>
                                <label>
                                    <input type="text" name="nosOfMemberAssigned" id="nosOfMemberAssigned" placeholder="Max No. of member assigned"><br>
                                    <small class="error-message" id="nosOfMemberAssigned_error"></small>
                                </label>
                                {{-- <select  name="assignedMember" id="assignedMember">
                                    <option value="">Select Name</option>
                                    <option value="all">Select All</option>
                                    @foreach ($members as $member)
                                    <option value="{{$member->_id}}" @if(in_array($member->_id, $assignedMemberIds)) disabled @endif>{{$member->Name}} @if(!empty($member->Middle_Name)){{$member->Middle_Name}} @endif{{$member->Surname}}</option>
                                    @endforeach
                                </select> --}}

                                <div id="assnMember"></div>
                                <input type="hidden" name="member_ids" id="member_ids">
                                <input type="hidden" name="member_names" id="member_names">

                                <small class="error-message" id="assignedMember_error"></small>
                            </div>
                        </div>
                        <div class="btn_frm">
                            <input type="submit" class="cmn_btn" id="submitBtn" value="Create Group">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Group Names from Controller
    const groupNames = @json($groupNames);

    // Handle Group Level Selection
    $('#level').on('change', function () {
        let selectedLevel = $(this).val(); // Get selected level
        if (groupNames[selectedLevel]) {
            $('#grpName').val(groupNames[selectedLevel]); // Auto-fill if level exists
            $('#grpName').prop('readonly', true);         // Make it read-only
        } else {
            $('#grpName').val('');                        // Clear input if new level
            $('#grpName').prop('readonly', false);        // Allow input
        }
    });
</script>
<script>
    $(document).ready(function() {

        class InputFormatter {
            // Function to format input
            static formatInput(value) {
                return value
                    .replace(/[-_]+/g, ' ')                // Replace hyphens and underscores with spaces
                    .replace(/([a-z])([A-Z])/g, '$1 $2')  // Add space for camelCase
                    .toLowerCase()                        // Convert to lowercase
                    .replace(/\s+/g, ' ')                 // Replace multiple spaces with single space
                    .trim();                              // Remove leading/trailing spaces
            }
        }
        // Function to update the hidden input field
        function updateHiddenInput() {
            var memberIds = [];
            var memberNames = [];
            $('#assnMember .member-item').each(function() {
                memberIds.push($(this).data('id'));
                memberNames.push($(this).data('name'));
            });
            $('#member_ids').val(memberIds.join(',')); // Member IDs as a comma-separated string
            $('#member_names').val(memberNames.join(',')); // Member IDs as a comma-separated string
        }

        // Handle selection changes
        $('#assignedMember').on('change', function() {
            var selectedMember = $(this).find('option:selected');
            var memberId = selectedMember.val();
            var memberName = selectedMember.text();

            if (memberId === 'all') {
                // "Select All" logic
                $('#assignedMember option:not(:disabled)').each(function () {
                    var id = $(this).val();
                    var name = $(this).text();

                    // Exclude "Select All" option
                    if (id && id !== 'all' && !$('#assnMember').find('[data-id="' + id + '"]').length) {
                        $('#assnMember').append(
                            '<div class="member-item" data-id="' + id + '" data-name="' + name + '">' +
                                name +
                                '<span class="remove">&times;</span>' +
                            '</div>'
                        );

                        // Disable the option
                        $(this).prop('disabled', true);
                    }
                });

                // Reset the dropdown after "Select All"
                $(this).val('');
                updateHiddenInput();
            } else if (memberId && memberId !== 'all' && !$('#assnMember').find('[data-id="' + memberId + '"]').length) {
                // Handle individual member selection
                $('#assnMember').append(
                    '<div class="member-item" data-id="' + memberId + '" data-name="' + memberName + '">' +
                        memberName +
                        '<span class="remove">&times;</span>' +
                    '</div>'
                );

                // Disable the selected option in the select box
                selectedMember.prop('disabled', true);
                $(this).val('');

                updateHiddenInput();
            }
        });

        // Handle remove button clicks
        $('#assnMember').on('click', '.remove', function() {
            var itemId = $(this).closest('.member-item').data('id');
            $('#assignedMember option[value="' + itemId + '"]').prop('disabled', false); // Re-enable the option
            $('#assignedMember option[value="' + itemId + '"]').prop('selected', false); // Unselect the option
            $(this).closest('.member-item').remove();
            updateHiddenInput();
        });

        // Real-time validation for "Level" field
        $('#level').on('change', function () {
            if ($(this).val()) {
                $('#level_error').text(''); // Clear error message
            }
        });

        // Real-time validation for "Designation" input
        $('#dsgHd1').on('input', function () {
            if ($(this).val()) {
                $('#dsgHd1_error').text(''); // Clear error message
            }
        });
        $('#nosOfMemberAssigned').on('input', function () {
            if ($(this).val()) {
                $('#nosOfMemberAssigned_error').text(''); // Clear error message
            }
        });

        // Real-time validation for member selection
        $('#assignedMember').on('change', function () {
            if ($('#assnMember .member-item').length > 0) {
                $('#assignedMember_error').text(''); // Clear error message if assnMember is not empty
            }
        });

        $('#dynamic-form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Check level
            let level = $('#level').val();
            if (!level) {
                $('#level_error').text('Please select a level.');
                isValid = false;
            }

            // Check designation input
            let dsgHd1 = $('#dsgHd1').val();
            if (!dsgHd1) {
                $('#dsgHd1_error').text('Please enter a designation.');
                isValid = false;
            }else {
                // Apply formatting during save
                let formattedDesignation = InputFormatter.formatInput(dsgHd1);
                $('#dsgHd1').val(formattedDesignation); // Update input with formatted value
            }

            let nosOfMemberAssigned = $('#nosOfMemberAssigned').val();
            if (!nosOfMemberAssigned) {
                $('#nosOfMemberAssigned_error').text('Please enter max number of members assigned');
                isValid = false;
            }

            // Check at least one member is added
            // let memberCount = $('#assnMember .member-item').length;
            // if (memberCount === 0) {
            //     $('#assignedMember_error').text('Please select at least one member.');
            //     isValid = false;
            // }

            if (isValid) {
                let formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function (response) {
                        // SweetAlert after success
                        Swal.fire({
                            title: response.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Complete',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Continue: Reload with fixed level, reset other fields
                                $('#dsgHd1').val('');
                                $('#nosOfMemberAssigned').val('');
                                $('#assignedMember').val('');
                                $('#assnMember').empty();
                                $('#member_ids').val('');
                                $('#member_names').val('');
                            } else {
                                const teamId = $('#teamId').val(); // Get the teamId value
                                window.location.href = `/admin/all-group/${teamId}`;
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                        });
                    },
                });
            }
        });
    });
</script>
@endsection