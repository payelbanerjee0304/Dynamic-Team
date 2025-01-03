@extends('layout.userapp')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="otr mmbr_pg_ottr ">
    <div class="container new">
    <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list cc-nws">
            <div class="heading">
                <h1>Birthdays</h1>
            </div>
        </div>
        <div class="tab admin_news">
            <!-- Tab Buttons -->
            <button class="tablinksNws" onclick="openNews(event, 'Ongoing')">Today</button>
            <button class="tablinksNws" onclick="openNews(event, 'Archive')">Upcoming</button>
        </div>
    </div>

    <div class="news_content">
        <!-- Ongoing Tab Content -->
        <div id="Ongoing" class="tabcontentNws">
            <div class="all_n_ews">
                @if (!empty($birthDays) && count($birthDays))
                @foreach ($birthDays as $user)
                @php
                    $dob = $user['DOB'];
                    $formattedDOB = null;
                    try {
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
                            // Format: YYYY-MM-DD
                            $formattedDOB = Carbon\Carbon::createFromFormat('Y-m-d', $dob)->format('jS F');
                        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
                            // Format: MM/DD/YYYY
                            $formattedDOB = Carbon\Carbon::createFromFormat('m/d/Y', $dob)->format('jS F');
                        }
                    } catch (\Exception $e) {
                        $formattedDOB = 'Invalid Date';
                    }
                @endphp
                <div class="n_roww">
                    <div class='nsw_img'>
                        <img src="{{ $user['image'] ? asset($user['image']) : asset('images/noImage.jpg') }}" alt="news-image"/>
                    </div>
                    <div class="n-cnttnt">
                    <h3 class="red">{{ $user['Name'] }} {{ $user['Middle_Name'] }} {{ $user['Surname'] }}</h3>
                    <p class="bdayDate">{{ $formattedDOB }}</p>
                    </div>
                    <div class="whtsup_btn">
                        <button class="cnct_icns_btn whts" data-mobile="{{ $user['Mobile'] }}" data-id="{{ $user['_id'] }}" data-name="{{ $user['Name']}}" data-midname="{{ $user['Middle_Name']}}" data-surname="{{ $user['Surname'] }}"><i class="fab fa-whatsapp"></i></button>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="n_roww">
                        <div class="n-cnttnt">
                            <h3 class="red">Sorry, there is no birthday today</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Archive Tab Content -->
        <div id="Archive" class="tabcontentNws">
            <div class="all_n_ews">
                @if (!empty($upcomingBirthdays) && count($upcomingBirthdays))
                @foreach ($upcomingBirthdays as $user)
                @php
                    $dob = $user['DOB'];
                    $formattedDOB = null;
                    try {
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
                            // Format: YYYY-MM-DD
                            $formattedDOB = Carbon\Carbon::createFromFormat('Y-m-d', $dob)->format('jS F');
                        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
                            // Format: MM/DD/YYYY
                            $formattedDOB = Carbon\Carbon::createFromFormat('m/d/Y', $dob)->format('jS F');
                        }
                    } catch (\Exception $e) {
                        $formattedDOB = 'Invalid Date';
                    }
                @endphp
                <div class="n_roww">
                    <div class='nsw_img'>
                        <img src="{{ $user['image'] ? asset($user['image']) : asset('images/noImage.jpg') }}" alt="news-image"/>
                    </div>
                    <div class="n-cnttnt">
                    <h3 class="red">{{ $user['Name'] }} {{ $user['Middle_Name'] }} {{ $user['Surname'] }}</h3>
                    <p class="bdayDate">{{ $formattedDOB }}</p>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="n_roww">
                        <div class="n-cnttnt">
                            <h3 class="red">Sorry there is no upcoming birthDays.</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    $(".cnct_icns_btn.whts").click(function(e) {
        e.preventDefault();

        const mobileNumber = $(this).data("mobile");
        const wpid = $(this).data("id");
        const wpname = $(this).data("name");
        const wpmidname = $(this).data("midname");
        const wpsurname = $(this).data("surname");

        const fullName = `${wpname} ${wpmidname} ${wpsurname}`;
        const message = `${fullName}, \nWishing you a day filled with happiness and a year filled with joy.\nHappy Birthday,\nGreetings from South Sabha`;
        // Construct WhatsApp deep link
        const whatsappUrl = `https://wa.me/${mobileNumber}?text=${encodeURIComponent(message)}`;

        window.open(whatsappUrl, "_blank");

        // Close the modal after opening WhatsApp
        // $("#whatsappModal").modal("hide");
        // window.location.reload();
    });
</script>
@endsection
