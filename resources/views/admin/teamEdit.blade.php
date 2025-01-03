@extends('layout.adminapp')


@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  .dsgtotl{
    display: flex;
    justify-content: space-between;
  }
  .dsg1{
    width:100%;
  }
</style>
<div class="otr">
    <div class="container">
      <div class="south_jst editor">
        <div class="mul_form">
          <div class="multi_top_dir">Edit Team Details</div>
            <form action="{{ route('admin.updateTeamDetails') }}" method="POST" id="dynamic-form">
                    @csrf
                    <div class="frm_cnt" id="frm_cnt1">
                        {{-- <h1>Membership Informations</h1> --}}
                        <input type="hidden" name=" teamId" id="teamId" value="{{ $id }}">
                        <div class="frm_row">
                            <label>Title</label>
                            <input type="text" name="team" id="team" placeholder="Enter Team" value="{{ $team->teamName }}" />
                            <small class="error-message" id="team_error"></small>
                        </div>
                        <div class="frm_row" hidden>
                            <label>Tenure</label>
                            <input type="text" id="dateRange" name="dateRange" placeholder="dd-mm-yyyy to dd-mm-yyyy" value="{{ $team->tenure }}" />
                            <small class="error-message" id="tenure_error"></small>
                        </div>
                    </div>
                    <div class="btn_frm">
                        <input type="submit" class="cmn_btn" id="submitBtn" value="Update">
                    </div>

            </form>
        </div>
      </div>
    </div>
</div>
@endsection


@section('customJs')
<!-- Bootstrap Date Range Picker JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {

        let preFilledDates = $("#dateRange").val();
        let startDate = moment(); // Default start date
        let endDate = moment(); // Default end date

        // Parse the pre-filled date range if available
        if (preFilledDates) {
            let dates = preFilledDates.split(" to "); // Split dates by 'to'
            if (dates.length === 2) {
                startDate = moment(dates[0], "DD-MM-YYYY"); // Parse start date
                endDate = moment(dates[1], "DD-MM-YYYY"); // Parse end date
            }
        }
        $("#dateRange").daterangepicker({
            startDate: startDate, // Set start date
            endDate: endDate,     // Set end date
            opens: "left", // Position the calendars to the left of the input field
            showDropdowns: true, // Show year and month dropdowns
            linkedCalendars: false, // Disable linked calendars
            autoUpdateInput: false, // Prevent automatic input field update
            locale: {
            format: "YYYY-MM-DD",
            separator: " to ",
            applyLabel: "Apply",
            cancelLabel: "Clear",
            customRangeLabel: "Custom",
            },
        });

        // Update input field when user selects a date range
        $("#dateRange").on("apply.daterangepicker", function (ev, picker) {
            $(this).val(
            picker.startDate.format("DD-MM-YYYY") +
                " to " +
                picker.endDate.format("DD-MM-YYYY")
            );
        });

        // Clear input field when user cancels selection
        $("#dateRange").on("cancel.daterangepicker", function (ev, picker) {
            $(this).val("");
        });

        if (preFilledDates) {
            $("#dateRange").val(preFilledDates);
        }
    });
</script>
@endsection