@extends('layout.adminapp')
@section('content')
<div class="otr">
    <div class="container">
      <div class="south_jst">
        <div class="mul_form">
          <div class="multi_top_dir">Upload Member Details</div>

            <form action="{{ route('admin.importMembersInsert') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="frm_cnt" id="frm_cnt2">
                    <div class="frm_row">
                        <label></label>
                        <div class="task_dD attach">
                            <label for=""><strong>Upload File</strong></label>
                            <div>
                                <input type="file" id="file" name="file" required/>
                            </div>
                            <small class="error-message" id="fileError"></small>
                        </div>
                    </div>
                </div>
                <div class="btn_frm">
                    <a href="{{route('admin.importMembersPage')}}" class="cmn_btn gre" id="resetBtn">Reset</a>
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
    });


</script>
@endsection