@extends('layout.adminapp')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="evnt_listing">
    <div class="mmbr_pg_list cc-nws">
        <div class="heading">
            <h1>All Events</h1>
        </div>
        <div class="c-nws">
            <a href="{{ route('admin.eventCreate') }}" class="mmbr_list_right_anch">Create Events</a>
        </div>
    </div>
    <div class="eventDetails__n">
        <table >
            <thead>
                <th>Event Title</th>
                <th>Event start Date</th>
                <th>Event start Time</th>
                <th>Event end Date</th>
                <th>Event end Time</th>
                <th>Banner Image</th>
                <th>Attentive Members</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @forEach($allEvent as $event)
                <tr>
                    <td><a href="{{ route('admin.eventDetails', ['eventId' => $event->_id]) }}" style="text-decoration: none; color: #717171;" >{{ $event->title }}</a></td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Ymd', $event->startDate)->format('jS M, Y') }}</td>
                    <td>{{ $event->startTime }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Ymd', $event->endDate)->format('jS M, Y') }}</td>
                    <td>{{ $event->endTime }}</td>
                    <td><img src="{{ $event->bannerImage }}" alt="" width="50"></td>
                    <td><a class="dropdown-item" href="{{ route('admin.interestedMembers', ['eventId' => $event->_id]) }}"><i class="fa-solid fa-eye"></i></a></td>
                    <td class="evnt_drop dropdown">
                        <!-- <div class="dropdown"> -->
                        <button class="btn ebnt_d dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('admin.editEvent', ['eventId' => $event->_id]) }}">Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete('{{ $event->_id }}')">Delete </a>
                        </div>
                        <!-- </div> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="page_pegination">
        {{ $allEvent->links() }}
    </div>
</div>
@endsection
@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    function confirmDelete(eventId) {
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
                    url: "{{ route('admin.deleteEvent') }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: eventId
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The event has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the event.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
@endsection


