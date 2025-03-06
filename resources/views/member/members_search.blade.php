<div class="event_table nw_member_table">
    <table style="width:100%">
        <thead>
            <tr>
                <th>Membership No.</th>
                <th>Name</th>
                <th>Phone No.</th>
                <th>Members Type</th>
                {{-- <th>Verfied</th> --}}
                {{-- <th>Id</th> --}}
                {{--<th>Download</th>--}}
                {{-- <th>Edit</th> --}}
            </tr>
        </thead>
        <tbody>
            @if($members->isNotEmpty())
                @foreach ($members as $member)
                    <tr>
                    {{--<td><input type="checkbox" name="selected_members[]" value="{{ $member['_id'] }}"></td>--}}
                        <td> {{ $member['Membership_No'] }} </td>
                        <td> {{ $member['Name'] }} {{ $member['Middle Name'] }} {{ $member['Surname'] }}
                        </td>
                        <td> {{ $member['Mobile'] }} </td>
                        <td> {{ $member['Members_Type'] }} </td>
                        {{-- <td> {{ $member['isVerified'] ?? 'No' }} </td> --}}
                        {{-- <td> {{$member['_id']}} </td> --}}
                        {{--<td> <a href="{{ route('downloadMemberData', ['id' => $member['_id']]) }}" class="">Download</a> </td>--}}
                        {{-- <td> <a href="{{ route('editMember', ['id' => $member['_id']]) }}"
                                target="_blank"><img src="{{ asset('images/edit_icon.png') }}"
                                    alt=""></a> </td> --}}
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">No data available</td>
                </tr>
            @endif
        </tbody>
        <div class="pagination">
            {{ $members->links() }}
        </div>
    </table>
</div>