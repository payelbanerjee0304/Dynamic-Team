@extends('layout.userapp')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .interested-btn{
        font-size: 14px;
        padding: 7px 10px;
        font-weight: 500;
        border: 1px solid transparent;
        font-family: poppins;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }
</style>
<div class="evnt_listing">
    <div class="mmbr_pg_list cc-nws">
        <div class="heading">
            <h1>All Events</h1>
        </div>
    </div>
    <div class="eventDetails__n">
        <table >
            <thead>
                <th>Banner Image</th>
                <th>Event Title</th>
                <th>Event start Date</th>
                <th>Event start Time</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @forEach($events as $event)
                @php
                    $interestedUsers = $event->interestedMembers ?? [];
                    $isInterested = in_array((string)Session::get('user_id'), $interestedUsers);
                @endphp
                <tr>
                    <td><img src="{{ $event->bannerImage }}" alt="" width="50"></td>
                    <td><a href="{{ route('admin.eventDetails', ['eventId' => $event->_id]) }}" style="text-decoration: none; color: #717171;" >{{ $event->title }}</a></td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Ymd', $event->startDate)->format('jS M, Y') }}</td>
                    <td>{{ $event->startTime }}</td>
                    <td>
                        @if(!$isInterested)
                            <button class="btn btn-lg btn-warning interested-btn" data-event-id="{{ $event->_id }}">
                                Interested? ({{ count($event->interestedMembers ?? []) }})
                            </button>
                        @else
                            <button class="btn btn-lg btn-success interested-btn" disabled>
                                Participating <i class="fa-solid fa-user-check" ></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $(".interested-btn").click(function () {
            let eventId = $(this).data("event-id");

            $.ajax({
                url: "/event/interested/" + eventId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === "success") {
                        alert("You have shown interest in this event!");
                        location.reload(); // Refresh to update the count
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert("Something went wrong! Please try again.");
                }
            });
        });
    });
</script>
@endsection


