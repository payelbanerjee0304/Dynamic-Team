@extends('layout.adminapp')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="otr mmbr_pg_ottr">
    <div class="container new">
      <div class="mmbr_pg_innr">
        <div class="mmbr_pg_list cc-nws">
            <div class="heading">
                <h1>All Teams</h1>
            </div>
            <div class="c-nws">
                <a href="{{ route('admin.createNewTeam') }}" class="mmbr_list_right_anch">Create Team</a>
            </div>
        </div>
        <div id="tableData">
            <div class="all-team table">
                <table>
                    <thead>
                        <tr>
                            <th class="team">Team</th>
                            <th class="tnur">Tenure</th>
                            <th class="grop">View Groups </th>
                            <th class="actn">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($allTeam->isNotEmpty())
                            @foreach ($allTeam as $all)
                            <tr>
                            <td class="team">{{ $all['teamName'] }}</td>
                            <td  class="tnur">{{ $all['tenure'] }}</td>
                            <td  class="grop"> 
                                    <a href="{{route('admin.allGroup', ['id' => $all['_id']])}}" class="ano-page">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            <td class="actn">  <div class="drv_tbl_icns dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-sort-up"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                            <button class="dpdn_btn_icns pen">
                                                <a href="{{route('admin.editTeamDetails', ['id' => $all['_id']])}}">
                                                    Edit
                                                </a>
                                            </button>
                                            </li>
                                            <li>
                                            <button class="dpdn_btn_icns trash">
                                                <a href="javascript:void(0);"  onclick="confirmDelete('{{ $all['_id'] }}')">
                                                Delete
                                                </a>
                                            </button>
                                            </li>
                                        </ul>
                                        </div>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="20">No data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection


@section('customJs')
<script>
    function confirmDelete(teamId) {
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
                    url: "{{ route('admin.deleteTeam') }}", // Make sure this route points to your delete action
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: teamId
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The team has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after deleting the course
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the team.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
@endsection