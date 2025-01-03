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
          <div class="multi_top_dir">Create Team</div>
            <form action="{{ route('admin.insertNewTeam') }}" method="POST" id="dynamic-form">
                    @csrf
                    <div class="frm_cnt" id="frm_cnt1">
                        {{-- <h1>Membership Informations</h1> --}}
                        <div class="frm_row">
                            <label>Title</label>
                            <input type="text" name="team" id="team" placeholder="Enter Team" />
                            <small class="error-message" id="team_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Tenure</label>
                            <input type="text" id="dateRange" name="dateRange" placeholder="dd-mm-yyyy to dd-mm-yyyy" />
                            <small class="error-message" id="tenure_error"></small>
                        </div>
                        {{-- <div class="frm_row">
                            <label>CEO (Level 1)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg1" id="dsg1" class="dsg1" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn1" value="Save" style="background-color: #ff0000; color: #fff">
                            </div>
                            <small class="error-message" id="dsg1_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>President (Level 2)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg2" id="dsg2" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn2" value="Save" style="background-color: #ff0000;color: #fff">
                            </div>
                            <small class="error-message" id="dsg2_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Vice-President (Level 3)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg3" id="dsg3" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn3" value="Save" style="background-color: #ff0000;color: #fff">
                            </div>
                            <small class="error-message" id="dsg3_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Chairperson (Level 4)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg4" id="dsg4" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn3" value="Save" style="background-color: #ff0000;color: #fff">
                            </div>
                            <small class="error-message" id="dsg4_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Managing Director (Level 5)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg5" id="dsg5" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn3" value="Save" style="background-color: #ff0000;color: #fff">
                            </div>
                            <small class="error-message" id="dsg5_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Executive Director (Level 6)</label>
                            <div class="dsgtotl">
                              <div class="dsginpt">
                                <input type="text" name="dsg6" id="dsg6" placeholder="Enter the name" />
                              </div>
                              <input type="submit" name="submit" class="btn" id="submitBtn3" value="Save" style="background-color: #ff0000;color: #fff">
                            </div>
                            <small class="error-message" id="dsg6_error"></small>
                        </div> --}}
                    </div>

                    <div class="btn_frm">
                        <input type="submit" class="cmn_btn" id="submitBtn" value="Submit">
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
      $("#dateRange").daterangepicker({
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
    });
</script>
@endsection