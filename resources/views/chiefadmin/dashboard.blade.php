@extends('layout.chiefadminapp')
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

    .e h3{
      text-transform: inherit !important ;
    }
</style>

<div id="loader" style="display: none;">
    <div class="loader"></div>
</div>
<div class="otr mmbr_pg_ottr">
    <div class="container new">
      <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list">
            <div class="heading" style="margin-bottom: 20px;" >
                <h1><strong>List of Organizers</strong></h1>
            </div>
          <div class="mmbr_pg_list_flx">
            <div class="mmbr_pg_list_lft">
              {{-- <select  id="membersType" name="membersType" class="mmbr_top_list">
                <option value="all">All</option>
                <option value="FOUNDER">FOUNDER </option>
                <option value="PATRON">PATRON </option>
                <option value="LIFE">LIFE </option>
              </select> --}}
            </div>
            
            <div class="mmbr_pg_list_rght">
              <div class="mmbr_list_right_flx">
                <div class="mmbr_list_right_lft">
                  {{-- <a href="javascript:void(0);" class="mmbr_list_right_anch" id="sendSMSBtn" style="padding-inline: 12px;">SMS</a> --}}
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
                  <a href="{{route('chiefadmin.addOrganizer')}}" class="mmbr_list_right_anch">Add Organizer</a>
                </div>
                {{-- <div class="mmbr_list_right_lft">
                    <select  id="verifyInp" name="verifyInp" class="mmbr_top_list">
                        <option value="all">All Member </option>
                        <option value="Yes">Verified</option>
                        <option value="No">Non-Verified</option>
                    </select>
                </div> --}}
                {{-- <div class="mmbr_list_right_dnld">
                  <button class="mmbr_rght_dnld_btn" id="mainDownload">
                    <img src="{{asset('images/nw-mmbr-dnld.png')}}" alt="img">
                  </button>
                </div> --}}
                {{-- <div class="mmbr_pg_list_lft">
                  <select  id="paginateInput" name="paginateInput" class="mmbr_top_list paginateInput">
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                    <option value="100">100</option>
                  </select>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
        <div id="tableData">
            @include('chiefadmin.dashboard_pagination')
        </div>
      </div>
    </div>
  </div>

@endsection


@section('customJs')
<script>
  function confirmDelete(organizerId) {
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
                    url: "{{ route('chiefadmin.deleteOrganizer') }}", // Make sure this route points to your delete action
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: organizerId
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

    $(document).ready(function() {
        function fetch_data(page) {
            $.ajax({
                url: "{{ route('chiefadmin.pagination') }}",
                data: { page: page },
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        }

        function search_data(keyword, page = 1) {
            $.ajax({
                url: "{{ route('chiefadmin.search') }}",
                data: { keyword: keyword, page: page },
                success: function(data) {
                    $('#tableData').html(data);
                    initializeMemberViewScripts();
                    pdfDownload();
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {

            event.preventDefault();

            var page = $(this).attr('href').split('page=')[1];
            var keyword = $('#keyword').val();
            if (keyword) 
            {
                search_data(keyword, page);
            }
            else 
            {
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

    });
</script>
@endsection