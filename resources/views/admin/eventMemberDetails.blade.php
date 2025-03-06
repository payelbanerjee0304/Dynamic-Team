@extends('layout.adminapp')
@section('content')
<style>
    .emal{
        text-transform: lowercase !important;
    }
</style>
<div class="evnt_listing">
    <div class="mmbr_pg_list cc-nws">
        <div class="heading">
            <h1>Attentive Members Details</h1>
        </div>
        {{-- <div class="c-nws">
            <a href="{{ route('admin.eventCreate') }}" class="mmbr_list_right_anch">Create Events</a>
        </div> --}}
    </div>
    <div class="eventDetails__n">
        <table>
            <thead>
                <th> </th>
                <th>Member Name</th>
                <th>Membership No</th>
                <th>Members Type</th>
                <th>Mobile No.</th>
                <th>Email Id</th>
            </thead>
            <tbody>
                @forelse($members as $memberDetails)
                    <tr>
                        <td>
                            <div class="mmbr_usrs">
                                @if($memberDetails->image)
                                    <img src="{{ $memberDetails->image }}" alt="img">
                                @else
                                    <img src="{{ asset('images/noImage.jpg') }}" alt="img">
                                @endif
                            </div>
                        </td>
                        <td>{{ $memberDetails->Name }} {{ $memberDetails->Middle_Name ?? '' }} {{ $memberDetails->Surname }}</td>
                        <td>{{ $memberDetails->Membership_No }}</td>
                        <td>{{ $memberDetails->Members_Type }}</td>
                        <td>{{ $memberDetails->Mobile }}</td>
                        <td class="emal">{{ $memberDetails->Email_ID }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="20">No attentive members to show</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="page_pegination">
        {{ $members->links() }}
    </div>
</div>
@endsection
@section('customJs')

@endsection