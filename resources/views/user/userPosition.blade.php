@extends('layout.userapp')
@section('content')
<style>
    th
    {
        border: 1px solid black; 
        font-size: 13px;
        padding: 10px;
    }
    td
    {
        border: 1px solid black; 
        font-size: 11px; 
        padding: 5px;
    }
    .all_n_ews h3.red 
    {
        margin-block: 10px;
    }
</style>
<div class="otr mmbr_pg_ottr ">
    <div class="container new">
        <div class="see_nwss">
            @if(!empty($memberName))
            <h1>Hello, {{ ucwords(strtolower($memberName)) }}</h1>
            @endif
            <h1>Position Details- (
                @if (!empty($highestPositions))
                    {{-- {{ ucwords(strtolower($highestPosition['designation'])) }} --}}
                    @foreach ($highestPositions as $position)
                        {{ ucwords(strtolower($position['designation'])) }}
                        @if (!$loop->last) , @endif <!-- Add comma if not the last item -->
                    @endforeach
                @else
                    No Active Position
                @endif
            )</h1>
        </div>

        <div class="all_n_ews">
            @if (!empty($memberHistory))
                {{-- @foreach ($memberHistory as $history)
                    <div class="n_roww">
                        <div class="n-cnttnt">
                            <h3 class="red">{{ $history['grouplevel'] }}</h3>
                            <h3 class="red">{{ $history['designation'] }}</h3>
                        </div>
                    </div>
                @endforeach --}}
                <div class="n_roww">
                <div class="n-cnttnt">
                <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                    <!-- Table Header -->
                    <thead>
                        <tr style="background-color: #f2f2f2; border: 1px solid black;">
                            <th>Team Name</th>
                            <th>Tenure</th>
                            <th>Group Name</th>
                            <th>Group Level</th>
                            <th>Designation</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($memberHistory as $history)
                            @php
                                $team = App\Models\Team::where('_id', $history['teamId'])->first();
                            @endphp
                            <tr>
                                <td>{{ $team->teamName ?? 'N/A' }}</td>
                                <td>{{ $history['tenure'] }}</td>
                                <td>{{ $history['groupName'] }}</td>
                                <td>{{ $history['grouplevel'] }}</td>
                                <td>{{ $history['designation'] }}</td>
                                <td>
                                    {{ date('d-m-Y', strtotime($history['positionStartDate'])) }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($history['positionEndDate'])) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                </div>
            @else
                <div class="no-content">
                    {{-- <h2>Still now , You are not holding any position. </h2> --}}
                </div>
            @endif
        </div>
      
</div>
@endsection

@section('customJs')

@endsection