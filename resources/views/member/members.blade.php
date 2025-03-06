@extends('layouts.layout')
<style>
    body{
        background: url(../images/image1.png) no-repeat;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
    }
    .btn{
        font-size: medium !important;
        }
    .suggestions-dropdown {
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        background: #fff;
        position: absolute;
        width: 21%;
        z-index: 1000;
    }
    .suggestions-dropdown div {
        padding: 8px;
        cursor: pointer;
    }
    .suggestions-dropdown div:hover {
        background: #f0f0f0;
    }

</style>

@section('content')
    <div class="otr">
        <div class="container">
            <div class="south_jst edit_member">
                <div class="top_hdr">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" />
                    </div>
                    <div class="top_h">
                        <h2>south calcutta<br/> sri jain swetamber terapanthi sabha</h2>
                    </div>
                </div>
                <div class="mul_form">
                    <div class="multi_top_dir">ALL MEMBERS </div>
                    <a href="{{route('admin.logout')}}"><button class="btn btn-info">Logout</button></a>
                    <a href="{{route('addMember')}}"><button class="btn btn-warning">Add New Member</button></a>
                    {{--<div class="search_bar">
                        <input type="text" id="keyword" name="keyword" placeholder="Name Search" class="search_holder" />
                        <input type="button" class="search-btn" />
                        <div id="suggestions" class="suggestions-dropdown" style="display: none;"></div>
                        <div class="btn btn-success" id="searchSubmit">search</div>
                    </div>
                    <div class="search_bar">
                    <select id="membersType" name="membersType" class="search_holder">
                        <option value="all">All</option>
                        <option value="FOUNDER">FOUNDER</option>
                        <option value="PATRON">PATRON</option>
                        <option value="LIFE">LIFE</option>
                    </select>
                    </div>
                    <div><button class="btn btn-danger" id="mainDownload">Download</button></div>--}}
                    <br><br>
                    <div id="tableData">
                        @include('member.members_pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetch_data(page) {
            $.ajax({
                url: "{{ route('allMembers.pagination') }}",
                data: { page: page },
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        }

        function search_data(keyword, page = 1) {
            $.ajax({
                url: "{{ route('allMembers.search') }}",
                data:{keyword: keyword, page: page},
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        }

        // New function for filtering by Members_Type
        function filter_data(membersType, page = 1) {
            $.ajax({
                url: "{{ route('allMembers.filter') }}",
                data: { membersType: membersType, page: page },
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        }


        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var keyword = $('#keyword').val();
            var membersType = $('#membersType').val();

            if(keyword)
            {
                search_data(keyword,page);
            }
            else if (membersType && membersType !== 'all') 
            {
                filter_data(membersType, page);
            }
            else 
            {
                fetch_data(page);
            }
        });

        $('#searchSubmit').on('click', function(event) {

            event.preventDefault();
            var keyword = $('#keyword').val();
            search_data(keyword);
            $('#suggestions').hide();
            });

            $('#keyword').on('keydown', function(event) {
            if (event.keyCode === 13) {  
                event.preventDefault();
                var keyword = $(this).val();
                search_data(keyword);
                $('#suggestions').hide();
            }
        });

        $('#keyword').on('input', function() {
            var keyword = $(this).val();
            if (keyword.length > 1) {
                $.ajax({
                    url: "{{ route('allMembers.suggestions') }}", // New route for suggestions
                    data: { keyword: keyword },
                    success: function(data) {
                        $('#suggestions').html(data).show();
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        $(document).on('click', '#suggestions div', function() {
            var selectedName = $(this).text();
            $('#keyword').val(selectedName);
            $('#suggestions').hide();
            search_data(selectedName);
        });


        // Trigger filter_data on membersType change
        $('#membersType').on('change', function() {
            var membersType = $(this).val();
            filter_data(membersType);
        });

        $('#mainDownload').on('click', function() {
            var keyword = $('#keyword').val();
            var membersType = $('#membersType').val();

            // Gather selected member IDs
            var selectedMembers = [];
            $('input[name="selected_members[]"]:checked').each(function() {
                selectedMembers.push($(this).val());
            });

            // If no members are selected, alert the user
            // if (selectedMembers.length === 0) {
            //     alert('Please select at least one member to download.');
            //     return;
            // }

            // Create the download URL with query parameters
            var downloadUrl = "{{ route('members.download') }}?keyword=" + encodeURIComponent(keyword)
                                + "&membersType=" + encodeURIComponent(membersType)
                                + "&selected_members=" + encodeURIComponent(selectedMembers.join(','));

            // Open download URL to trigger the download
            window.location.href = downloadUrl;
        });

        
    </script>
@endsection
