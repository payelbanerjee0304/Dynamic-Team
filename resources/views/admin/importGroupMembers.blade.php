@extends('layout.adminapp')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="otr">
    <div class="container">
      <div class="south_jst">
        <div class="mul_form">
          <div class="multi_top_dir">Import Members for: {{ $team->teamName }}</div>

            <form action="{{ route('admin.importGroups', $id) }}" method="POST" id="importGroupTeam" enctype="multipart/form-data">
                @csrf
                <div class="frm_cnt" id="frm_cnt2">
                    @if(session('success'))
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('admin.allGroup', $id) }}";
                            });
                        </script>
                    @endif
                    @if(session('error'))
                        <script>
                            Swal.fire({
                                title: 'Error!',
                                text: '{{ session('error') }}',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        </script>
                    @endif
                    <div class="frm_row">
                        <label></label>
                        <div class="task_dD attach">
                            <label for=""><strong>Upload Excel File</strong></label>
                            <div>
                                <input type="file" name="file" id="file" class="form-control" >
                            </div>
                            <small class="error-message" id="fileError"></small>
                        </div>
                    </div>
                </div>
                <div class="btn_frm">
                    <a href="{{ route('admin.allGroup', $id) }}" class="cmn_btn gre" id="resetBtn">Back</a>
                    <input type="submit" class="cmn_btn" id="submitBtn" value="Submit">
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection


@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#file').on('change', function () {
            var fileInput = $(this); // File input field
            var filePath = fileInput.val(); // Get the file path
            var allowedExtensions = /(\.xls|\.xlsx|\.csv)$/i; // Allowed file extensions
            var errorMessage = $('#fileError'); // Error message element

            // Clear any existing error message
            errorMessage.text('');

            // Validate file type
            if (!allowedExtensions.test(filePath)) {
                errorMessage.text('Invalid file type. Only .xls, .xlsx, or .csv files are allowed.');
                fileInput.val(''); // Clear the file input if invalid
            }
        });

        $('#importGroupTeam').submit(function (e) {
            // e.preventDefault();
            
            let fileInput = $('#file');
            let fileError = $('#fileError');

            // Reset the error message
            fileError.hide();

            // Check if the file input is empty
            if (fileInput.val() === '') {
                e.preventDefault(); // Prevent form submission
                fileError.text('Please upload an Excel file.').show();
            }
        });
    });


</script>
@endsection
