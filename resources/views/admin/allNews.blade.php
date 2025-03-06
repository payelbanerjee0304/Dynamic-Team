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
    .mmbr_top_list.paginateInput {
        width: 67px !important;
    }
    #smsForm .form-control, #whatsappForm .form-control {
        font-size: 14px;
    }
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
    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="otr mmbr_pg_ottr ">
    <!-- <div class="container new">
        <div class="mmbr_pg_innr">
            <div class="mmbr_pg_list">
                <div class="heading">
                    <h1>All News</h1>
                </div>
            </div>
            <div class="tab admin_news" >
                <button class="tablinksNwsNws " onclick="openNews(event, 'Ongoing')">Ongoing({{ count($ongoingNews) }})</button>
                <button class="tablinksNws" onclick="openNews(event, 'Archive')">Archive({{ count($archivedNews) }})</button>
            </div>
        </div>

        <div class="news_content">
            <div id="Ongoing" class="tabcontentNws">
                <div class="mmbr_pg_tbl">
                    <div class="member_view_div sth_nws_admin">
                        <div class="new">
                            <div class="member_v_hdr">
                                <div class="a"><h3 class="nme">Logo</h3>
                              <h3>Title</h3></div>
                                <div class="b">
                                    <h3>Start Date</h3>
                                    <h3>End Date</h3>
                                </div>
                                <div class="c"><h3>Action</h3></div>
                            </div>
                        </div>
                        @foreach ($ongoingNews as $update)
                        <div class="member_view_b">
                            <div class="member_row">
                                <div class="d">
                                    <div class="mmbr_usr_ttl">
                                        <div class="mmbr_usrs">
                                            <span>
                                                <img src="{{ $update['image'] }}" alt="Preview Img">
                                            </span>
                                        </div>
                                    </div>
                                    <h3 class="red">{{ $update['title'] }}</h3>
                                </div>
                                <div class="e">
                                    <h3>{{ DateTime::createFromFormat('Ymd', $update['startDate'])->format('d/m/Y') }}</h3>
                                    <h3>{{ DateTime::createFromFormat('Ymd', $update['endDate'])->format('d/m/Y') }}</h3>
                                </div>
                                <div class="f">
                                    <div class="drv_tbl_icns dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-sort-up"></i>
                                        </button> 
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dpdn_btn_icns pen">
                                                    <a href="https://form.perfectcreate.com/admin/edit-member/67189507fb4738ac8043f192">Edit</a>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dpdn_btn_icns trash">
                                                    <a href="#"id="delete_news" class="delete_news" data-id="{{ $update['_id'] }}">Delete</a>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="Archive" class="tabcontentNws">
            <div class="mmbr_pg_tbl">
                    <div class="member_view_div sth_nws_admin">
                        <div class="new">
                            <div class="member_v_hdr">
                                <div class="a"><h3 class="nme">Logo</h3>
                              <h3>Title</h3></div>
                                <div class="b">
                                    <h3>Start Date</h3>
                                    <h3>End Date</h3>
                                </div>
                                <div class="c"><h3>Action</h3></div>
                            </div>
                        </div>
                        @foreach ($ongoingNews as $update)
                        <div class="member_view_b">
                            <div class="member_row">
                                <div class="d">
                                    <div class="mmbr_usr_ttl">
                                        <div class="mmbr_usrs">
                                            <span>
                                                <img src="{{ $update['image'] }}" alt="Preview Img">
                                            </span>
                                        </div>
                                    </div>
                                    <h3 class="red">{{ $update['title'] }}</h3>
                                </div>
                                <div class="e">
                                    <h3>{{ DateTime::createFromFormat('Ymd', $update['startDate'])->format('d/m/Y') }}</h3>
                                    <h3>{{ DateTime::createFromFormat('Ymd', $update['endDate'])->format('d/m/Y') }}</h3>
                                </div>
                                <div class="f">
                                    <div class="drv_tbl_icns dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-sort-up"></i>
                                        </button> 
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dpdn_btn_icns pen">
                                                    <a href="https://form.perfectcreate.com/admin/edit-member/67189507fb4738ac8043f192">Edit</a>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dpdn_btn_icns trash">
                                                    <a href="#"id="delete_news" class="delete_news" data-id="{{ $update['_id'] }}">Delete</a>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container new">
    <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list cc-nws">
            <div class="heading">
                <h1>All News</h1>
            </div>
            <div class="c-nws">
                <a href="{{ route('admin.newsCreate') }}" class="mmbr_list_right_anch">Create News</a>
            </div>
            {{-- <div class="c-nws">
                <a href="javascriptvoid:(0);" class="mmbr_list_right_anch">Create News</a>
            </div> --}}
        </div>
        <div class="tab admin_news">
            <!-- Tab Buttons -->
            <button class="tablinksNws" onclick="openNews(event, 'Ongoing')">Ongoing({{ count($ongoingNews) }})</button>
            <button class="tablinksNws" onclick="openNews(event, 'Archive')">Archive({{ count($archivedNews) }})</button>
        </div>
    </div>

    <div class="news_content">
        <!-- Ongoing Tab Content -->
        <div id="Ongoing" class="tabcontentNws">
            <div class="mmbr_pg_tbl">
                <div class="member_view_div sth_nws_admin">
                    <div class="new">
                        <div class="member_v_hdr">
                            <div class="a"><h3 class="nme">Logo</h3>
                            <h3>Title</h3></div>
                            <div class="b">
                                <h3>Start Date</h3>
                                <h3>End Date</h3>
                            </div>
                            <div class="c"><h3>Action</h3></div>
                        </div>
                    </div>
                    @foreach ($ongoingNews as $update)
                    <div class="member_view_b">
                        <div class="member_row">
                            <div class="d">
                                <div class="mmbr_usr_ttl">
                                    <div class="mmbr_usrs">
                                        <span>
                                            <a href="{{ route('admin.newsDetails', ['newsId' => $update['_id']]) }}">
                                                <img src="{{ $update['image'] }}" alt="Preview Img">
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <h3 class="red">{{ $update['title'] }}</h3>
                            </div>
                            <div class="e">
                                <h3>{{ DateTime::createFromFormat('Ymd', $update['startDate'])->format('d/m/Y') }}</h3>
                                <h3>{{ DateTime::createFromFormat('Ymd', $update['endDate'])->format('d/m/Y') }}</h3>
                            </div>
                            <div class="f">
                                <div class="drv_tbl_icns dropdown">
                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-sort-up"></i>
                                    </button> 
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dpdn_btn_icns pen">
                                                <a href="{{ route('admin.editNews', ['newsId' => $update['_id']]) }}" id="edit_news">Edit</a>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dpdn_btn_icns trash">
                                                <a href="#"id="delete_news" class="delete_news" data-id="{{ $update['_id'] }}">Delete</a>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Archive Tab Content -->
        <div id="Archive" class="tabcontentNws">
            <div class="mmbr_pg_tbl">
                <div class="member_view_div sth_nws_admin">
                    <div class="new">
                        <div class="member_v_hdr">
                            <div class="a"><h3 class="nme">Logo</h3>
                            <h3>Title</h3></div>
                            <div class="b">
                                <h3>Start Date</h3>
                                <h3>End Date</h3>
                            </div>
                            <div class="c"><h3>Action</h3></div>
                        </div>
                    </div>
                    @foreach ($archivedNews as $update)
                    <div class="member_view_b">
                        <div class="member_row">
                            <div class="d">
                                <div class="mmbr_usr_ttl">
                                    <div class="mmbr_usrs">
                                        <span>
                                            <a href="{{ route('admin.newsDetails', ['newsId' => $update['_id']]) }}">
                                                <img src="{{ $update['image'] }}" alt="Preview Img">
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <h3 class="red">{{ $update['title'] }}</h3>
                            </div>
                            <div class="e">
                                <h3>{{ DateTime::createFromFormat('Ymd', $update['startDate'])->format('d/m/Y') }}</h3>
                                <h3>{{ DateTime::createFromFormat('Ymd', $update['endDate'])->format('d/m/Y') }}</h3>
                            </div>
                            <div class="f">
                                <div class="drv_tbl_icns dropdown">
                                    <a href="#"id="delete_news" class="delete_news" data-id="{{ $update['_id'] }}" style="font-size: 14px;">Delete</a>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle delete button click
        $('.delete_news').on('click', function() {
            var newsId = $(this).data('id');

            console.log(newsId)

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You really want to delete the News!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with AJAX request
                    $.ajax({
                        url: "{{ route('admin.deleteNews') }}", // Your route to handle deletion
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            newsId: newsId,
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'News has been deleted.',
                                'success'
                            ).then(() => {
                                // Optionally reload the page or update the UI
                                window.location.reload();
                            });
                        }.bind(this), // Ensure `this` refers to the clicked element
                        error: function(xhr) {
                            // Handle error
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the Program.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    function openNews(evt, cityName) {
        var i, tabcontentNws, tablinksNws;
        // Hide all tab contents
        tabcontentNws = document.getElementsByClassName("tabcontentNws");
        for (i = 0; i < tabcontentNws.length; i++) {
            tabcontentNws[i].style.display = "none";
        }
        // Remove active class from all buttons
        tablinksNws = document.getElementsByClassName("tablinksNws");
        for (i = 0; i < tablinksNws.length; i++) {
            tablinksNws[i].className = tablinksNws[i].className.replace(" active", "");
        }
        // Show the selected tab content and add active class to the button
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Set the default tab as active when the page loads
    document.addEventListener("DOMContentLoaded", function() {
        // Simulate a click on the first tab to set it as the default
        const defaultTab = document.querySelector(".tablinksNws");
        if (defaultTab) {
            defaultTab.click();
        }
    });
</script>
@endsection
