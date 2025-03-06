@extends('layout.adminapp')


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
            <form action="{{ route('admin.insertMember') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="frm_cnt" id="frm_cnt1">
                        <h1>Membership Informations</h1>
                        <div class="frm_row">
                            <label>Membership No.</label>
                            <input type="text" id="Membership_No" name="Membership_No" />
                            <small class="error-message" id="Membership_No-error"></small>
                        </div>

                        <div class="frm_row">
                            <label>Member of Sabha</label>
                            <div class="check">
                                <span> <input type="radio" value="FOUNDER" name="Members_Type" /> <label>
                                        Founder</label></span>
                                <span> <input type="radio" value="PATRON" name="Members_Type" /> <label>
                                        Patron</label> </span>
                                <span> <input type="radio" value="LIFE" name="Members_Type" />
                                    <label>Life</label></span>
                            </div>
                            <small class="error-message" id="Members_Type-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Surname</label>
                            <input type="text" name="Surname" />
                            <small class="error-message" id="Surname-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Name</label>
                            <input type="text" name="Name" />
                            <small class="error-message" id="Name-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Middle Name</label>
                            <input type="text" name="MidName" />
                        </div>
                        <div class="frm_row">
                            <label>Father’s Name</label>
                            <input type="text" name="Son_Daughter_of" />
                            <small class="error-message" id="Son_Daughter_of-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Spouse Name</label>
                            <input type="text" name="Spouse" />
                        </div>
                        <div class="frm_row">
                            <label>Gender</label>
                            <div class="check">
                              <span><input type="radio" value="Male" name="gender" /> <label>
                                Male</label></span>
                              <span><input type="radio" value="Female" name="gender" /> <label>
                                Female</label></span>
                            </div>
                        </div>
                        <div class="frm_row">
                            <label>Do you have Terpanth Card?</label>
                            <div class="check">
                                <span><input type="radio" value="Yes" name="hasTerapanthCard" /> <label>
                                        Yes</label></span>
                                <span><input type="radio" value="No" name="hasTerapanthCard" /> <label>
                                        No</label></span>
                            </div>
                            <small class="error-message" id="hasTerapanthCard-error"></small>
                        </div>
                    </div>

                    <div class="frm_cnt" id="frm_cnt2" style="display: none;">
                        <h1>Personal Information</h1>
                        <div class="frm_d_div add_form">
                            <div class="frm_row">
                                <label>Date of Birth</label>
                                <input type="date" name="DOB" id="dob" onchange="calculateAge()" max="{{ date('Y-m-d', strtotime('-18 years')) }}" />
                                <small class="error-message" id="DOB-error"></small>
                            </div>
                            <div class="frm_row">
                                <label>Age</label>
                                <input type="text" name="age" id="age" readonly />
                            </div>
                        </div>
                        <div class="frm_d_div add_form">
                            <div class="frm_row">
                                <label>Date of Marriage</label>
                                <input type="date" name="DOM" id="DOM" max="{{ now()->format('Y-m-d') }}"/>
                                <span class="error-message" id="DOM-error"></span>
                            </div>
                            <div class="frm_row">
                                <label>Blood Group</label>
                                {{-- <input type="text" name="bloodGroup" /> --}}
                                <select name="bloodGroup" id="bloodGroup">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="AB+">AB+</option>
                                    <option value="O+">O+</option>
                                    <option value="A-">A-</option>
                                    <option value="B-">B-</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O-">O-</option>
                                </select>
                                <small class="error-message" id="bloodGroup-error"></small>
                            </div>
                        </div>
                        <div class="frm_d_div add_form">
                            <div class="frm_row">
                                <label>Qualification</label>
                                <input type="text" name="Qualification" />
                                <small class="error-message" id="Qualification-error"></small>
                            </div>
                            <div class="frm_row">
                                <label>Occupation</label>
                                <input type="text" name="Occupation" />
                                <small class="error-message" id="Occupation-error"></small>
                            </div>
                        </div>

                        <div class="frm_row">
                            <label>Mobile No.</label>
                            <input type="number" name="Mobile" />
                            <small class="error-message" id="Mobile-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Alternative Mobile No.</label>
                            <input type="number" name="alternateNumber" />
                        </div>
                        <div class="frm_row">
                            <label>Email</label>
                            <input type="text" name="Email_ID" />
                            <small class="error-message" id="Email_ID-error"></small>
                        </div>



                        <div class="frm_row">
                            <label>Upload Photo</label>
                            <div class="task_dD attach">
                                {{-- <div id="dropArea" class="drag-area">
                                    <p>Drag file to upload</p>
                                </div> --}}
                                <img id="imagePreview" src="{{asset('images/upload_img.png')}}" alt="Preview Img" data-default-src="{{asset('images/upload_img.png')}}" />
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
                            <input type="text" name="Residence1" />
                            <small class="error-message" id="Residence1-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Street Name</label>
                            <textarea name="Residence2"></textarea>
                            <small class="error-message" id="Residence2-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Area</label>
                            <input type="text" name="Residence3" />
                            <small class="error-message" id="Residence3-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>City</label>
                            <input type="text" name="Residence4" />
                            <small class="error-message" id="Residence4-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Pincode</label>
                            <input type="number" name="Res_PINCODE" />
                            <small class="error-message" id="Res_PINCODE-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Native Place</label>
                            <input type="text" name="Native_Place" />
                            <small class="error-message" id="Native_Place-error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Phone No.</label>
                            <input type="number" name="Phone" />
                            <small class="error-message" id="Phone-error"></small>
                        </div>
                        {{-- <div class="frm_row">
                            <label>Number of Family Members</label>
                            <input type="text" name="familyDetails" id="familyDetails" onkeyup="generateFamilyFields()" />
                        </div>
                        <div id="familyFieldsContainer"></div> --}}
                        <div class="frm_row nw_ad_frm_lb">
                        <label>Family Member 1(Optional)</label>
                        </div>
                        <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                            <div class="frm_row">
                            
                                <input type="text" name="familyMember1Name" id="familyMember1Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember1Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember1Phone" id="familyMember1Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember1Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember1Relation" id="familyMember1Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Sister">Daughter</option>
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
                            
                                <input type="text" name="familyMember2Name" id="familyMember2Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember2Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember2Phone" id="familyMember2Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember2Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember2Relation" id="familyMember2Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
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
                            
                                <input type="text" name="familyMember3Name" id="familyMember3Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember3Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember3Phone" id="familyMember3Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember3Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember3Relation" id="familyMember3Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
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
                            
                                <input type="text" name="familyMember4Name" id="familyMember4Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember4Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember4Phone" id="familyMember4Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember4Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember4Relation" id="familyMember4Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
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
                            
                                <input type="text" name="familyMember5Name" id="familyMember5Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember5Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember5Phone" id="familyMember5Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember5Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember5Relation" id="familyMember5Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
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
                            
                                <input type="text" name="familyMember6Name" id="familyMember6Name" placeholder="Enter Name"/>
                                <small class="error-message" id="familyMember6Name-error"></small>
                            </div>
                            <div class="frm_row_rltn">
                            <div class="frm_row">
                                <input type="text" name="familyMember6Phone" id="familyMember6Phone" placeholder="Enter Phone" />
                                <small class="error-message" id="familyMember6Phone-error"></small>
                            </div>
                            <div class="frm_row">
                                <select name="familyMember6Relation" id="familyMember6Relation">
                                    <option value="">Select Relation</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
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
                            <input type="text" name="businessName" />
                        </div>
                        <div class="frm_row">
                            <label>Flat No. & Building Name</label>
                            <input type="text" name="Office-1" placeholder="Office/Business" />
                        </div>
                        <div class="frm_row">
                            <label>Street Name</label>
                            <textarea name="Office-2" placeholder="Office/Business"></textarea>
                        </div>
                        <div class="frm_row">
                            <label>Area</label>
                            <input type="text" name="Office-3"  placeholder="Office/Business"/>
                        </div>
                        <div class="frm_row">
                            <label>City</label>
                            <input type="text" name="Office-4"  placeholder="Office/Business"/>
                        </div>
                        <div class="frm_row">
                            <label>Pincode</label>
                            <input type="number" name="PINCODE" placeholder="Office/Business"/>
                        </div>
                        <div class="frm_row">
                            <label>Deals In</label>
                            <input type="text" name="Deals_In" placeholder="Office/Business"/>
                        </div>
                        <div class="frm_row">
                            <label>Phone No.</label>
                            <input type="number" name="Phone_O" placeholder="Office/Business"/>
                        </div>
                        <div class="frm_row">
                            <label>Mobile No.</label>
                            <input type="number" name="Mobile_O" placeholder="Office/Business"/>
                        </div>
                        {{-- <div class="frm_row">
                            <label>Fax No.</label>
                            <input type="number" name="businessFaxNo" placeholder="Office/Business"/>
                        </div> --}}
                        <div class="frm_row">
                        <label>Email</label>
                        <input type="text" name="Email_O" placeholder="Office/Business" />
                        </div>
                    </div>

                    <div class="btn_frm">
                        <a href="javascript:void(0);" class="cmn_btn gre" id="backBtn" style="display: none;">Back</a>
                        <a href="javascript:void(0);" class="cmn_btn" id="nextBtn">Next</a>
                        <a href="{{route('admin.addMember')}}" class="cmn_btn gre" id="resetBtn" style="display: none;">Reset</a>
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
        let currentStep = 1;
        const totalSteps = 4;

        // Function to validate form inputs
        function validateCurrentStep(step) {
            let isValid = true;

            if (step === 1) {
                // Validate Membership No
                const membershipNo = $("#Membership_No").val().trim();
                if (membershipNo === "") {
                    $("#Membership_No-error").text("Membership No is required.");
                    isValid = false;
                } else {
                    $("#Membership_No-error").text("");
                }

                // Validate Members Type (Radio buttons)
                const membersType = $("input[name='Members_Type']:checked").val();
                if (!membersType) {
                    $("#Members_Type-error").text("Please select a member type.");
                    isValid = false;
                } else {
                    $("#Members_Type-error").text("");
                }

                // Validate Surname
                const surname = $("input[name='Surname']").val().trim();
                if (surname === "") {
                    $("#Surname-error").text("Surname is required.");
                    isValid = false;
                } else {
                    $("#Surname-error").text("");
                }

                // Validate Name
                const name = $("input[name='Name']").val().trim();
                if (name === "") {
                    $("#Name-error").text("Name is required.");
                    isValid = false;
                } else {
                    $("#Name-error").text("");
                }

                // Validate Father's Name
                // const fatherName = $("input[name='Son_Daughter_of']").val().trim();
                // if (fatherName === "") {
                //     $("#Son_Daughter_of-error").text("Father's name is required.");
                //     isValid = false;
                // } else {
                //     $("#Son_Daughter_of-error").text("");
                // }

                // // Validate Terapanth Card (Radio buttons)
                // const terapanthCard = $("input[name='hasTerapanthCard']:checked").val();
                // if (!terapanthCard) {
                //     $("#hasTerapanthCard-error").text("Please select whether you have a Terapanth card.");
                //     isValid = false;
                // } else {
                //     $("#hasTerapanthCard-error").text("");
                // }
            }

            if (step === 2) {
                // Validate Date of Birth (DOB)
                const dob = $("#dob").val();
                if (dob === "") {
                    $("#DOB-error").text("Date of Birth is required.");
                    isValid = false;
                } else {
                    $("#DOB-error").text("");
                }

                // Validate Age (Ensure DOB is entered before age)
                const age = $("#age").val();
                if (age === "") {
                    $("#age-error").text("Age is automatically calculated from DOB.");
                    isValid = false;
                } else {
                    $("#age-error").text("");
                }

                // Validate Date of Marriage (DOM)
                const dom = $("#DOM").val();
                if (dom === "") {
                    $("#DOM-error").text("Date of Marriage is required.");
                    isValid = false;
                } else {
                    $("#DOM-error").text("");
                }

                // Validate Blood Group
                const bloodGroup = $("#bloodGroup").val();
                if (bloodGroup === "") {
                    $("#bloodGroup-error").text("Please select a Blood Group.");
                    isValid = false;
                } else {
                    $("#bloodGroup-error").text("");
                }

                // Validate Qualification
                const qualification = $("input[name='Qualification']").val().trim();
                if (qualification === "") {
                    $("#Qualification-error").text("Qualification is required.");
                    isValid = false;
                } else {
                    $("#Qualification-error").text("");
                }

                // Validate Occupation
                const occupation = $("input[name='Occupation']").val().trim();
                if (occupation === "") {
                    $("#Occupation-error").text("Occupation is required.");
                    isValid = false;
                } else {
                    $("#Occupation-error").text("");
                }

                // Validate Mobile Number
                const mobile = $("input[name='Mobile']").val().trim();
                if (mobile === "") {
                    $("#Mobile-error").text("Mobile Number is required.");
                    isValid = false;
                } else if (!/^\d{10}$/.test(mobile)) {
                    $("#Mobile-error").text("Please enter a valid 10-digit Mobile Number.");
                    isValid = false;
                } else {
                    $("#Mobile-error").text("");
                }

                // Validate Email ID
                const email = $("input[name='Email_ID']").val().trim();
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (email === "") {
                    $("#Email_ID-error").text("Email ID is required.");
                    isValid = false;
                } else if (!emailPattern.test(email)) {
                    $("#Email_ID-error").text("Please enter a valid email address.");
                    isValid = false;
                } else {
                    $("#Email_ID-error").text("");  // Clear the error message if email is valid
                }
            }

            if (step === 3) {
                // Validate Flat No. & Building Name.
                const residence1 = $("input[name='Residence1']").val().trim();
                if (residence1 === "") {
                    $("#Residence1-error").text("Flat No. & Building Name is required.");
                    isValid = false;
                } else {
                    $("#Residence1-error").text("");
                }

                // Validate Street Name
                const residence2 = $("textarea[name='Residence2']").val().trim();
                if (residence2 === "") {
                    $("#Residence2-error").text("Street Name is required.");
                    isValid = false;
                } else {
                    $("#Residence2-error").text("");
                }

                // Validate Area
                const residence3 = $("input[name='Residence3']").val().trim();
                if (residence3 === "") {
                    $("#Residence3-error").text("Area is required.");
                    isValid = false;
                } else {
                    $("#Residence3-error").text("");
                }

                // Validate City
                const residence4 = $("input[name='Residence4']").val().trim();
                if (residence4 === "") {
                    $("#Residence4-error").text("City is required.");
                    isValid = false;
                } else {
                    $("#Residence4-error").text("");
                }

                // Validate Pincode
                const resPincode = $("input[name='Res_PINCODE']").val().trim();
                if (resPincode === "") {
                    $("#Res_PINCODE-error").text("Pincode is required.");
                    isValid = false;
                } else if (!/^\d{6}$/.test(resPincode)) {
                    $("#Res_PINCODE-error").text("Please enter a valid 6-digit Pincode.");
                    isValid = false;
                } else {
                    $("#Res_PINCODE-error").text("");
                }

                // Validate Native Place
                const nativePlace = $("input[name='Native_Place']").val().trim();
                if (nativePlace === "") {
                    $("#Native_Place-error").text("Native Place is required.");
                    isValid = false;
                } else {
                    $("#Native_Place-error").text("");
                }

                // Validate Phone Number
                const phone = $("input[name='Phone']").val().trim();
                if (phone === "") {
                    $("#Phone-error").text("Phone Number is required.");
                    isValid = false;
                } else {
                    $("#Phone-error").text("");
                }

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

        // Function to update progress bar
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

        // Function to show the current step
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

        // Real-time validation for each field
        $("input, select, textarea").on("input change", function() {
            const fieldName = $(this).attr("name");
            validateCurrentStep(currentStep);  // Trigger validation for the current step
        });

        // Next button click event
        $("#nextBtn").click(function() {
            // Validate the current step
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