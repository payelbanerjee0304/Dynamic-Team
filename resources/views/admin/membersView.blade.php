@extends('layout.adminapp')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
  .suggestions-dropdown {
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        background: #fff;
        position: absolute;
        width: 100%;
        z-index: 1000;
        font-size: 13px;
    }
    .suggestions-dropdown div {
        padding: 8px;
        cursor: pointer;
    }
    .suggestions-dropdown div:hover {
        background: #f0f0f0;
    }
    .mmbr_top_list.paginateInput{
      width: 67px !important;
    }

    #smsForm .form-control{
        font-size: 14px;
    }
    #whatsappForm .form-control{
        font-size: 14px;
    }

    /* payel loader add */
    #loader {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    }

    /* Loader spinner */
    .loader {
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    }

    /* Spinner animation */
    @keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    }
    /* payel loader add */
</style>

<div id="loader" style="display: none;">
    <div class="loader"></div>
</div>
<div class="otr mmbr_pg_ottr">
    <div class="container new">
      <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list">
            <div class="heading" style="margin-bottom: 20px;" >
                <h1><strong>List of Members</strong></h1>
            </div>
          <div class="mmbr_pg_list_flx">
            <div class="mmbr_pg_list_lft">
              <select  id="membersType" name="membersType" class="mmbr_top_list">
                <option value="all">All({{$allCount}})</option>
                <option value="FOUNDER">FOUNDER ({{$founderCount}})</option>
                <option value="PATRON">PATRON ({{$patronCount}})</option>
                <option value="LIFE">LIFE ({{$lifeCount}})</option>
              </select>
            </div>
            
            <div class="mmbr_pg_list_rght">
              <div class="mmbr_list_right_flx">
                <div class="mmbr_list_right_lft">
                  <a href="javascript:void(0);" class="mmbr_list_right_anch" id="sendSMSBtn" style="padding-inline: 12px;">SMS</a>
                </div>
                <div class="mmbr_list_right_lft">
                  <a href="{{route('admin.addMember')}}" class="mmbr_list_right_anch">Add Member</a>
                </div>
                <div class="mmbr_list_right_all">
                  <input type="text" id="keyword" name="keyword" placeholder="Search" class="mmbr_list_right_srch" autocomplete="off">
                  <div class="serchAl"  id="searchSubmit">
                    <img src="{{asset('images/nw-mmbr_srch.png')}}" alt="">
                  </div>
                  <div id="suggestions" class="suggestions-dropdown" style="display: none;"></div>
                  <input type="hidden" name="selectedMemberId" id="selectedMemberId">
                </div>
                <div class="mmbr_list_right_lft">
                    <!-- <input type="hidden" name="verifyInp" id="verifyInp">
                    <a href="javascript:void(0);" class="mmbr_list_right_anch" id="verified" style="padding-inline: 2px;">Verified({{$verifiedCount}})</a> -->
                    <select  id="verifyInp" name="verifyInp" class="mmbr_top_list">
                        <option value="all">All Member </option>
                        <option value="Yes">Verified ({{$verifiedCount}})</option>
                        <option value="No">Non-Verified</option>
                    </select>
                </div>
                <div class="mmbr_list_right_dnld">
                  <button class="mmbr_rght_dnld_btn" id="mainDownload">
                    <img src="{{asset('images/nw-mmbr-dnld.png')}}" alt="img">
                  </button>
                </div>
                <div class="mmbr_pg_list_lft">
                  {{-- <h1>Pagination</h1> --}}
                  <select  id="paginateInput" name="paginateInput" class="mmbr_top_list paginateInput">
                    <option value="20"{{$paginateInput==='20' ? 'selected' : '' }}>20</option>
                    <option value="50"{{$paginateInput==='50' ? 'selected' : '' }}>50</option>
                    <option value="75"{{$paginateInput==='75' ? 'selected' : '' }}>75</option>
                    <option value="100"{{$paginateInput==='100' ? 'selected' : '' }}>100</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="tableData">
          @include('admin.membersView_pagination')
        </div>
      </div>
    </div>
  </div>

@endsection


@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function fetch_data(page) {
            var paginateInput = $('#paginateInput').val();
            $.ajax({
                url: "{{ route('allMember.pagination') }}",
                data: { page: page, paginateInput: paginateInput },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                }
            });
        }

        function search_data(keyword, page = 1) {
            $('#membersType').val('all');
            $('#verifyInp').val('all');
            var paginateInput = $('#paginateInput').val();
            $.ajax({
                url: "{{ route('allMember.search') }}",
                data: { keyword: keyword, page: page, paginateInput: paginateInput },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                }
            });
        }

        function filter_data(membersType, page = 1) {
            $('#keyword').val('');
            $('#verifyInp').val('all');
            var paginateInput = $('#paginateInput').val();
            $.ajax({
                url: "{{ route('allMember.filter') }}",
                data: { membersType: membersType, page: page, paginateInput: paginateInput },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                }
            });
        }

        function filterVerify(status, page = 1) {
            $('#keyword').val('');
            var paginateInput = $('#paginateInput').val();
            $('#membersType').val('all');
            $('#selectedMemberId').val('');
            $.ajax({
                url: "{{ route('allMember.filterVerify') }}",
                data: { status: status, page: page, paginateInput: paginateInput },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                }
            });
        }
        $('#paginateInput').on('change', function() {
            var keyword = $('#keyword').val();
            var membersType = $('#membersType').val();
            var status = $('#verifyInp').val();
            var page = 1; // Reset to the first page on changing pagination

            if (keyword) 
            {
                search_data(keyword, page);
            } else if (membersType && membersType !== 'all') 
            {
                filter_data(membersType, page);
            }else if (status && status !== 'all') 
            {
                filterVerify(status, page);
            } else 
            {
                fetch_data(page);
            }
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var keyword = $('#keyword').val();
            var membersType = $('#membersType').val();
            var status = $('#verifyInp').val();
            if (keyword) {
                search_data(keyword, page);
            } else if (membersType && membersType !== 'all') {
                filter_data(membersType, page);
            }else if (status && status !== 'all') {
                filterVerify(status, page);
            } else {
                fetch_data(page);
            }
        });

        $('#searchSubmit').on('click', function(event) {
            event.preventDefault();
            $('#verifyInp').val('all');
            var keyword = $('#keyword').val();
            search_data(keyword);
            $('#suggestions').hide();
        });

        $('#keyword').on('keydown', function(event) {
            $('#verifyInp').val('all');
            if (event.keyCode === 13) {  
                event.preventDefault();
                var keyword = $(this).val();
                search_data(keyword);
                $('#suggestions').hide();
            }
        });

        $('#keyword').on('input', function() {
            var keyword = $(this).val();
            $('#verifyInp').val('all');
            if (keyword.length > 1) {
                $.ajax({
                    url: "{{ route('allMember.suggestions') }}",
                    data: { keyword: keyword },
                    success: function(data) {
                        $('#suggestions').html(data).show();
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        // Event for selecting a suggestion
        $(document).on('click', '#suggestions div', function() {
            var selectedFullName = $(this).text(); // Get the full name from data attribute
            var selectedId = $(this).data('id'); // Get the full name from data attribute
            $('#verifyInp').val('all');
            console.log(selectedId);
            // $('#keyword').val(selectedFullName);
            $('#selectedMemberId').val(selectedId);
            $('#suggestions').hide();
            $('#keyword').val('');
            search_data_keyword(selectedId); // Perform search with the selected full name            
        });

        function search_data_keyword(selectedId, page = 1) {
            $('#membersType').val('all');
            $('#verifyInp').val('all');
            var paginateInput = $('#paginateInput').val();
            $.ajax({
                url: "{{ route('allMember.searchKeyword') }}",
                data: { selectedId: selectedId, page: page, paginateInput: paginateInput },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                }
            });
        }


        $('#membersType').on('change', function() {
            var membersType = $(this).val();
            $('#verifyInp').val('all');
            filter_data(membersType);
        });

        // $('#verified').on('click', function() {
        //     var status = 'Yes';
        //     filterVerify(status);
        //     $('#verifyInp').val(status);
        // });
        $('#verifyInp').on('change', function() {
            var status = $(this).val();
            filterVerify(status);
        });
    });

    $('#mainDownload').on('click', function() {
        var keyword = $('#keyword').val();
        var membersType = $('#membersType').val();
        var selectedMemberId = $('#selectedMemberId').val();
        var verifyInp = $('#verifyInp').val();
        var selectedMembers = [];

        // Gather selected member IDs
        $('input[name="selected_members[]"]:checked').each(function() {
            selectedMembers.push($(this).val());
        });

        if (selectedMemberId) {
            selectedMembers.push(selectedMemberId);
        }

        // Show loader when download starts
        $('#loader').show();

        // AJAX request to initiate the download
        $.ajax({
            url: "{{ route('members.download') }}",
            method: 'GET',
            data: {
                keyword: keyword,
                membersType: membersType,
                verifyInp: verifyInp,
                selected_members: selectedMembers.join(',')
            },
            xhrFields: {
                responseType: 'blob' // Set the response type to blob to handle the file download
            },
            success: function(response) {
                // Hide the loader once the download completes
                $('#loader').hide();

                // Create a URL for the download and trigger it
                var downloadUrl = window.URL.createObjectURL(response);
                var a = document.createElement('a');
                a.href = downloadUrl;
                a.download = "members_download.xlsx"; // Set the desired file name
                document.body.appendChild(a);
                a.click();
                a.remove();

                // Revoke the object URL to free memory
                window.URL.revokeObjectURL(downloadUrl);
            },
            error: function() {
                // Hide the loader if there's an error
                $('#loader').hide();
                alert('Failed to download. Please try again.');
            }
        });
    });

    function confirmDelete(memberId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e13333',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.deleteMember') }}", // Make sure this route points to your delete action
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: memberId
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The member has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after deleting the course
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the member.',
                            'error'
                        );
                    }
                });
            }
        });
    }
        
</script>

<script>
    function initializeMemberViewScripts() {
        $(".cnct_icns_btn.sms").click(function() {
            // Get mobile number and member ID
            const mobileNumber = $(this).data("mobile");
            const memberId = $(this).data("id");

            $.ajax({
            url: "/admin/send-sms",
            method: "POST",
            data: {
                mobile_number: mobileNumber,
                memberId: memberId,
                _token: "{{ csrf_token() }}" // Laravel CSRF token
            },
            success: function(response) {
                if (response.success) {
                    console.log("Message sent: " + response.success);
                alert("SMS sent successfully!");
                // $("#smsModal").modal("hide");
                window.location.reload();
                } else {
                alert("Failed to send SMS.");
                }
            },
            error: function(error) {
                console.error("Error:", error);
            }
            });
        });
    }
    $(document).ready(function() {
        // SMS button click event
        initializeMemberViewScripts();

        // wp button click event
        $(".cnct_icns_btn.whts").click(function(e) {
            e.preventDefault();

            const mobileNumber = $(this).data("mobile");
            const wpid = $(this).data("id");
            const wpname = $(this).data("name");
            const wpmidname = $(this).data("midname");
            const wpsurname = $(this).data("surname");

            const fullName = `${wpname} ${wpmidname} ${wpsurname}`;
            const message = `${fullName},\n\nKindly update your membership data & family details in the below link:\n\ntinyurl.com/southsaba\n\nSouth Sabha`;
            // Construct WhatsApp deep link
            const whatsappUrl = `https://wa.me/${mobileNumber}?text=${encodeURIComponent(message)}`;

            window.open(whatsappUrl, "_blank");
        });

        $('#selectAll').click(function() {
            $('.mmbr_usr_check').prop('checked', this.checked);
        });

        $('#sendSMSBtn').click(function() {
            var selectedMembers = [];
            
            // Get the selected member IDs and their mobile numbers
            $('.mmbr_usr_check:checked').each(function() {
                var memberId = $(this).val();
                var mobile = $(this).data('mobile');
                selectedMembers.push({ memberId: memberId, mobile: mobile });
            });
            console.log(selectedMembers);

            if (selectedMembers.length > 0) {
                // Send the selected members' data to the backend
                $.ajax({
                    url: '/admin/sendAll-sms', // Backend route to send SMS
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        selected_members: selectedMembers,
                        // message: "SOUTH_CALCUTTA_SHRI_JAIN"
                    },
                    success: function(response) {
                        alert('SMS sent successfully to selected members!');
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to send SMS. Please try again.');
                    }
                });
            } else {
                alert('Please select at least one member.');
            }
        });
    });

</script>
@endsection