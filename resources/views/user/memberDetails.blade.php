@extends('layout.userapp')


@section('content')
<style>
  .num_div.active{
    background-color: red !important;
    color: white !important;
  }
  .num_div.active .num{
    color: white !important;
  }

  .line_span.active {
    background-color: red !important;
    display: inline-block !important;
  }
  .cmn_btn.rgstr{
    padding: 6px 12px !important;
    background-color: blue !important;
    border: 2px solid blue !important;
  }
  .cmn_btn.rgstr:hover {
      color: blue !important;
      border: 2px solid blue !important;
      background-color: #fff !important;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="otr">
    <div class="container">
      <div class="south_jst">
        <div class="mul_form">
          <div class="multi_top_dir">Form for Member’s Directory</div>

          <div class="progress_bar">
            <div class="num_div">
              <span class="num"> 1 </span>
            </div>
            <span class="line_span"></span>
            <div class="num_div">
              <span class="num"> 2 </span>
            </div>
            <span class="line_span"></span>
            <div class="num_div">
              <span class="num"> 3 </span>
            </div>
            <span class="line_span"></span>
            <div class="num_div">
              <span class="num"> 4 </span>
            </div>
          </div>

          <form action="{{ route('update-member-session') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="memberId" value="{{ $member['_id'] }}">
            <div class="frm_cnt" id="frm_cnt1">
              <h1>Membership Informations</h1>
              <div class="frm_row">
                <label>Membership No.</label>
                <input type="text" id="memberNumber" name="Membership_No" value="{{ $member['Membership_No'] }}" readonly disabled />
              </div>

              <div class="frm_row">
                <label>Member of Sabha</label>
                <div class="check">
                  <span> <input type="radio" name="Members_Type"
                  value="FOUNDER" @if($member['Members_Type']=="FOUNDER") checked @endif disabled /> <label>
                          Founder</label></span>
                  <span> <input type="radio" name="Members_Type"
                  value="PATRON" @if($member['Members_Type']=="PATRON") checked @endif disabled /> <label>
                          Patron</label> </span>
                  <span> <input type="radio" name="Members_Type"
                  value="LIFE" @if($member['Members_Type']=="LIFE") checked @endif disabled />
                      <label>Life</label></span>
                </div>
              </div>
              <div class="frm_row">
                <label>Surname</label>
                <input type="text" name="Surname" value="{{ $member['Surname'] }}" />
              </div>
              <div class="frm_row">
                <label>Name</label>
                <input type="text" name="Name" value="{{ $member['Name'] }}" />
              </div>
              <div class="frm_row">
                <label>Middle Name</label>
                <input type="text" name="MidName" value="{{ $member['Middle_Name'] }}" />
              </div>
              <div class="frm_row">
                <label>Father’s Name</label>
                <input type="text" name="Son_Daughter_of" value="{{ $member['Son_Daughter_of'] }}" />
              </div>
              <div class="frm_row">
                <label>Spouse Name</label>
                <input type="text" name="Spouse" value="{{ $member['Spouse'] }}" />
              </div>
              <div class="frm_row">
                <label>Gender</label>
                <div class="check">
                  <span><input type="radio" value="Male" name="gender" @if($member['gender']=="Male") checked @endif /> <label>
                    Male</label></span>
                  <span><input type="radio" value="Female" name="gender" @if($member['gender']=='Female') checked @endif/> <label>
                    Female</label></span>
                </div>
              </div>
              <div class="frm_row">
                <label>Do you have Terpanth Card?</label>
                <div class="check">
                  <span><input type="radio" value="Yes" name="hasTerapanthCard" id="registerCardAlrdy" @if($member['hasTerapanthCard']=="Yes") checked @endif /> <label>
                          Yes</label></span>
                  <span><input type="radio" value="No" name="hasTerapanthCard" id="registerCard" @if($member['hasTerapanthCard']=='No') checked @endif/> <label>
                          No</label></span>
                  <span><a href="https://terapanthnetwork.com" target="_blank" class="cmn_btn rgstr" id="rgstrBtn" style="display: none">Register</a></span>
                </div>
              </div>
            </div>

            <div class="frm_cnt" id="frm_cnt2" style="display: none;">
              <h1>Personal Informations</h1>
              @php
                  $dob = \DateTime::createFromFormat('m/d/Y', $member['DOB']) ?: \DateTime::createFromFormat('Y-m-d', $member['DOB']);
                  $dom = \DateTime::createFromFormat('m/d/Y', $member['DOM']) ?: \DateTime::createFromFormat('Y-m-d', $member['DOM']);
                  $formattedDOB = $dob ? $dob->format('Y-m-d') : '';
                  $formattedDOM = $dom ? $dom->format('Y-m-d') : '';

                  $age = null;
    
                  if ($dob) {
                      // Calculate age
                      $today = new \DateTime();
                      $age = $today->diff($dob)->y;
                  }
              @endphp
              <div class="frm_d_div add_form">
                <div class="frm_row">
                    <label>Date of Birth</label>
                    <input type="date" name="DOB" id="dob" onchange="calculateAge()" value="{{ $formattedDOB }}"  max="{{ date('Y-m-d', strtotime('-18 years')) }}" />
                </div>
                <div class="frm_row">
                    <label>Age</label>
                    <input type="text" name="age" id="age" value="{{ $age }}" readonly />
                </div>
              </div>
              <div class="frm_d_div add_form">
                <div class="frm_row">
                    <label>Date of Marriage</label>
                    <input type="date" name="DOM" value="{{ $formattedDOM }}" max="{{ now()->format('Y-m-d') }}" />
                </div>
                <div class="frm_row">
                    <label>Blood Group</label>
                    {{-- <input type="text" name="bloodGroup" /> --}}
                    <select name="bloodGroup" id="bloodGroup">
                        <option value="">Select</option>
                        <option value="A+"{{ $member['bloodGroup'] == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="B+"{{ $member['bloodGroup'] == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="AB+"{{ $member['bloodGroup'] == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="O+"{{ $member['bloodGroup'] == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="A-"{{ $member['bloodGroup'] == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B-"{{ $member['bloodGroup'] == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB-"{{ $member['bloodGroup'] == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O-"{{ $member['bloodGroup'] == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>
              </div>
              <div class="frm_d_div add_form">
                <div class="frm_row">
                  <label>Qualification</label>
                  <input type="text" name="Qualification"  value="{{ $member['Qualification'] }}" />
                </div>
                <div class="frm_row">
                  <label>Occupation</label>
                  <input type="text" name="Occupation"  value="{{ $member['Occupation'] }}" />
                </div>
              </div>

              <div class="frm_row">
                <label>Mobile No.</label>
                <input type="number" name="Mobile" value="{{ $member['Mobile'] }}" readonly disabled/>
              </div>
              <div class="frm_row">
                <label>Alternative Mobile No.</label>
                <input type="number" name="alternateNumber" value="{{ $member['alternateNumber'] }}" />
              </div>
              <div class="frm_row">
                <label>Email</label>
                <input type="text" name="Email_ID" value="{{ $member['Email_ID'] }}" />
              </div>

              <div class="frm_row">
                <label>Upload Photo</label>
                <div class="task_dD attach">
                    {{-- <div id="dropArea" class="drag-area">
                        <p>Drag file to upload</p>
                    </div> --}}
                    <img id="imagePreview" src="{{ $member['image'] ? asset($member['image']) : asset('images/upload_img.png') }}" alt="Preview Img" />
                    <span id="icon" class="cmn_btn wht">Select File</span>
                    <div>
                        <input type="file" id="fileInput" accept="image/*" style="display:none;"
                            name="image" />
                        <div class="preview" id="preview"></div>
                    </div>
                </div>
              </div>
            </div>

            <div class="frm_cnt" id="frm_cnt3" style="display: none;">
              <h1>Residential Informations</h1>
              <div class="frm_row">
                <label>Flat No. & Building Name</label>
                <input type="text" name="Residence1" value="{{ $member['Residence1'] }}" />
              </div>
              <div class="frm_row">
                  <label>Street Name</label>
                  <textarea name="Residence2">{{ $member['Residence2'] }}</textarea>
              </div>
              <div class="frm_row">
                  <label>Area</label>
                  <input type="text" name="Residence3" value="{{ $member['Residence3'] }}" />
              </div>
              <div class="frm_row">
                  <label>City</label>
                  <input type="text" name="Residence4" value="{{ $member['Residence4'] }}" />
              </div>
              <div class="frm_row">
                  <label>Pincode</label>
                  <input type="number" name="Res_PINCODE" value="{{ $member['Res_PINCODE'] }}" />
              </div>
              <div class="frm_row">
                  <label>Native Place</label>
                  <input type="text" name="Native_Place" value="{{ $member['Native_Place'] }}" />
              </div>
              <div class="frm_row">
                <label>Phone No.</label>
                <input type="number" name="Phone" value="{{ $member['Phone'] }}" />
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 1(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember1Name" id="familyMember1Name" value="{{ $member['familyMember1Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember1Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember1Phone" id="familyMember1Phone" value="{{ $member['familyMember1Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember1Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember1Relation" id="familyMember1Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember1Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember1Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember1Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember1Relation-error"></small>
                  </div>
                </div>
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 2(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember2Name" id="familyMember2Name" value="{{ $member['familyMember2Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember2Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember2Phone" id="familyMember2Phone" value="{{ $member['familyMember2Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember2Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember2Relation" id="familyMember2Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember2Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember2Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember2Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember2Relation-error"></small>
                  </div>
                </div>
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 3(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember3Name" id="familyMember3Name" value="{{ $member['familyMember3Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember3Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember3Phone" id="familyMember3Phone" value="{{ $member['familyMember3Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember3Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember3Relation" id="familyMember3Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember3Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember3Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember3Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember3Relation-error"></small>
                  </div>
                </div>
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 4(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember4Name" id="familyMember4Name" value="{{ $member['familyMember4Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember4Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember4Phone" id="familyMember4Phone" value="{{ $member['familyMember4Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember4Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember4Relation" id="familyMember4Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember4Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember4Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember4Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember4Relation-error"></small>
                  </div>
                </div>
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 5(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember5Name" id="familyMember5Name" value="{{ $member['familyMember5Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember5Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember5Phone" id="familyMember5Phone" value="{{ $member['familyMember5Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember5Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember5Relation" id="familyMember5Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember5Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember5Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember5Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember5Relation-error"></small>
                  </div>
                </div>
              </div>
              <div class="frm_row nw_ad_frm_lb">
              <label>Family Member 6(Optional)</label>
              </div>
              <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                <div class="frm_row">
                    <input type="text" name="familyMember6Name" id="familyMember6Name" value="{{ $member['familyMember6Name'] }}" placeholder="Enter Name"/>
                    <small class="error-message" id="familyMember6Name-error"></small>
                </div>
                <div class="frm_row_rltn">
                  <div class="frm_row">
                      <input type="number" name="familyMember6Phone" id="familyMember6Phone" value="{{ $member['familyMember6Phone'] }}" placeholder="Enter Phone" />
                      <small class="error-message" id="familyMember6Phone-error"></small>
                  </div>
                  <div class="frm_row">
                      <select name="familyMember6Relation" id="familyMember6Relation">
                          <option value="">Select Relation</option>
                          <option value="Mother"{{ $member['familyMember6Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                          <option value="Son"{{ $member['familyMember6Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                          <option value="Daughter"{{ $member['familyMember6Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                      </select>
                      <small class="error-message" id="familyMember6Relation-error"></small>
                  </div>
                </div>
              </div>
            </div>

            <div class="frm_cnt" id="frm_cnt4" style="display: none;">
              <h1>Business Informations</h1>
              <div class="frm_row">
                <label>Business Name</label>
                <input type="text" name="businessName" value="{{$member['businessName']}}" />
              </div>
              <div class="frm_row">
                  <label>Flat No. & Building Name</label>
                  <input type="text" name="Office-1" value="{{$member['Office-1']}}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                <label>Street Name</label>
                <textarea name="Office-2" placeholder="Office/Business"> {{$member['Office-2']}}</textarea>
              </div>
              <div class="frm_row">
                <label>Area</label>
                <input type="text" name="Office-3"  value="{{$member['Office-3']}}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                  <label>City</label>
                  <input type="text" name="Office-4"  value="{{$member['Office-4']}}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                <label>Pincode</label>
                <input type="number" name="PINCODE" value="{{ $member['PINCODE'] }}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                <label>Deals In</label>
                <input type="text" name="Deals_In" value="{{ $member['Deals_In'] }}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                <label>Phone No.</label>
                <input type="number" name="Phone_O" value="{{ $member['Phone_O'] }}" placeholder="Office/Business" />
              </div>
              <div class="frm_row">
                <label>Mobile No.</label>
                <input type="number" name="Mobile_O" value="{{ $member['Mobile_O'] }}" placeholder="Office/Business" />
              </div>
              {{-- <div class="frm_row">
                  <label>Fax No.</label>
                  <input type="number" name="businessFaxNo" value="{{ $member['businessFaxNo'] }}" placeholder="Office/Business" />
              </div> --}}
              <div class="frm_row">
                <label>Email</label>
                <input type="text" name="Email_O" value="{{ $member['Email_O'] }}" placeholder="Office/Business" />
              </div>
            </div>
            <div class="btn_frm">
              <a href="javascript:void(0);" class="cmn_btn gre" id="backBtn" style="display: none;">Back</a>
              <a href="javascript:void(0);" class="cmn_btn" id="nextBtn">Next</a>
              <a href="{{route('memberDetails')}}" class="cmn_btn gre" id="resetBtn" style="display: none;">Reset</a>
              <input type="submit" class="cmn_btn" id="submitBtn" style="display: none;" value="Submit">
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
@section('customJs')
<script>
  function calculateAge() {
      const dob = document.getElementById("dob").value;
      if (dob) {
          const dobDate = new Date(dob);
          const today = new Date();
          let age = today.getFullYear() - dobDate.getFullYear();
          const monthDiff = today.getMonth() - dobDate.getMonth();
  
          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
              age--;
          }
  
          document.getElementById("age").value = age;
      }
  }

  $(document).ready(function() {
    // Check if the "No" option is already selected and show the button if true
    if ($('#registerCard').is(':checked')) {
        $('#rgstrBtn').show();
    }

    // Toggle the button when the "No" radio button is clicked
    $('#registerCard').on('change', function() {
        if ($(this).is(':checked')) {
            $('#rgstrBtn').show();
        }
    });
    $('#registerCardAlrdy').on('change', function() {
        if ($(this).is(':checked')) {
            $('#rgstrBtn').hide();
        }
    });
  });

  $(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;

    // Function to validate form inputs
    function validateCurrentStep(step) {
      let isValid = true;

      if (step === 3) {

          for (let i = 1; i <= 6; i++) {
              const name = $(`input[name='familyMember${i}Name']`).val().trim();
              const phone = $(`input[name='familyMember${i}Phone']`).val().trim();
              const relation = $(`select[name='familyMember${i}Relation']`).val().trim();

              // Check if the name is provided, then phone and relation should be filled
              if (name !== "") {
                  if (phone === "") {
                      $(`#familyMember${i}Phone`).next('.error-message').text("Phone is required.");
                      isValid = false;
                  } else {
                      $(`#familyMember${i}Phone`).next('.error-message').text("");
                  }

                  if (relation === "") {
                      $(`#familyMember${i}Relation`).next('.error-message').text("Relation is required.");
                      isValid = false;
                  } else {
                      $(`#familyMember${i}Relation`).next('.error-message').text("");
                  }
              } else {
                  // Clear errors if name is empty (no validation required for empty fields)
                  $(`#familyMember${i}Phone`).next('.error-message').text("");
                  $(`#familyMember${i}Relation`).next('.error-message').text("");
              }
          }
      }

      // Add additional validation for other steps if needed

      return isValid;
    }

    function updateProgressBar(step) {
        $(".num_div").removeClass("active");
        $(".line_span").removeClass("active");

        for (let i = 1; i <= step; i++) {
            $(`.num_div:nth-child(${(i * 2) - 1})`).addClass("active");
            if (i < step) {
                $(`.line_span:nth-child(${i * 2})`).addClass("active");
            }
        }
    }

    function showStep(step) {
        console.log("Showing Step:", step);
        $(".frm_cnt").hide();  // Hide all form content sections
        $(`#frm_cnt${step}`).show();  // Show the current step

        // Button visibility logic
        if (step === 1) {
            $("#backBtn").hide();
            $("#nextBtn").show();
            $("#resetBtn").hide();
            $("#submitBtn").hide();
        } else if (step === totalSteps) {
            $("#backBtn").show();
            $("#nextBtn").hide();
            $("#resetBtn").show();
            $("#submitBtn").show();
        } else {
            $("#backBtn").show();
            $("#nextBtn").show();
            $("#resetBtn").hide();
            $("#submitBtn").hide();
        }

        updateProgressBar(step);
    }

    // Initial display for step 1
    showStep(currentStep);

    $("input, select, textarea").on("input change", function() {
        const fieldName = $(this).attr("name");
        validateCurrentStep(currentStep);  // Trigger validation for the current step
    });

    // Next button click event
    $("#nextBtn").click(function() {
      if (validateCurrentStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });

    // Back button click event
    $("#backBtn").click(function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });
  });
</script>
@endsection