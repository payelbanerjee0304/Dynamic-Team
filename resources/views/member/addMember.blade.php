@extends('layouts.layout')

@section('content')
<style>
    .btn{
        font-size: medium;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <div class="otr">
        <div class="container">
            <div class="south_jst">
                <div class="top_hdr">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" />
                    </div>
                    <div class="top_h">
                        <h2>south calcutta<br/> sri jain swetamber terapanthi sabha</h2>
                    </div>
                </div>
                <div class="mul_form">
                    <div class="multi_top_dir">FORM FOR MEMBER’S DIRECTORY</div>
                    <a href="{{route('allMembers')}}"><button class="btn btn-secondary">Back</button></a>
                    <a href="{{route('admin.logout')}}"><button class="btn btn-info">Logout</button></a>

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

                    <form action="{{ route('insertMember') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="frm_cnt">
                            <h1>Membership Informations</h1>
                            <div class="frm_row">
                                <label>Membership No.</label>
                                <input type="text" id="memberNumber" name="Membership_No" />
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
                            </div>
                            <div class="frm_row">
                                <label>Surname</label>
                                <input type="text" name="Surname" />
                            </div>
                            <div class="frm_row">
                                <label>Name</label>
                                <input type="text" name="Name" />
                            </div>
                            <div class="frm_row">
                                <label>Middle Name</label>
                                <input type="text" name="MidName" />
                            </div>
                            <div class="frm_row">
                                <label>Father/Husband’s Name</label>
                                <input type="text" name="Son_Daughter_of" />
                            </div>
                            <div class="frm_row">
                                <label>Spouse Name</label>
                                <input type="text" name="Spouse" />
                            </div>
                            <div class="frm_row">
                                <label>Do you have Terpanth Card?</label>
                                <div class="check">
                                    <span><input type="radio" value="Yes" name="hasTerapanthCard" /> <label>
                                            Yes</label></span>
                                    <span><input type="radio" value="No" name="hasTerapanthCard" /> <label>
                                            No</label></span>
                                </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Personal Information</h1>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Birth</label>
                                    <input type="date" name="DOB" id="dob" onchange="calculateAge()" max="{{ date('Y-m-d', strtotime('-18 years')) }}" />
                                </div>
                                <div class="frm_row">
                                    <label>Age</label>
                                    <input type="text" name="age" id="age" readonly />
                                </div>
                            </div>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Marriage</label>
                                    <input type="date" name="DOM" max="{{ now()->format('Y-m-d') }}"/>
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
                                </div>
                            </div>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Qualification</label>
                                    <input type="text" name="Qualification" />
                                </div>
                                <div class="frm_row">
                                    <label>Occupation</label>
                                    <input type="text" name="Occupation" />
                                </div>
                            </div>

                            <div class="frm_row">
                                <label>Mobile No.</label>
                                <input type="number" name="Mobile" />
                            </div>
                            <div class="frm_row">
                                <label>Alternative Mobile No.</label>
                                <input type="number" name="alternateNumber" />
                            </div>
                            <div class="frm_row">
                                <label>Email</label>
                                <input type="text" name="Email_ID" />
                            </div>



                            <div class="frm_row">
                                <label>Upload Photo</label>
                                <div class="task_dD attach">
                                    <div id="dropArea" class="drag-area">
                                        <p>Drag file to upload</p>
                                    </div>
                                    <img id="imagePreview" src="./images/upload_img.png" alt="Preview Img" />
                                    <span id="icon" class="cmn_btn wht">Select File</span>
                                    <div>
                                        <input type="file" id="fileInput" accept="image/*" style="display:none;"
                                            name="image" />
                                        <div class="preview" id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Residential Informations</h1>
                            <div class="frm_row">
                                <label>Premises No.</label>
                                <input type="text" name="Residence1" />
                            </div>
                            <div class="frm_row">
                                <label>Street Name</label>
                                <textarea name="Residence2"></textarea>
                            </div>
                            <div class="frm_row">
                                <label>Area</label>
                                <input type="text" name="Residence3" />
                            </div>
                            <div class="frm_row">
                                <label>City</label>
                                <input type="text" name="Residence4" />
                            </div>
                            <div class="frm_row">
                                <label>Pincode</label>
                                <input type="text" name="Res_PINCODE" />
                            </div>
                            <div class="frm_row">
                                <label>Native Place</label>
                                <input type="text" name="Native_Place" />
                            </div>
                            <div class="frm_row">
                                <label>Phone No.</label>
                                <input type="number" name="Phone" />
                            </div>
                            {{-- <div class="frm_row">
                                <label>Number of Family Members</label>
                                <input type="text" name="familyDetails" id="familyDetails" onkeyup="generateFamilyFields()" />
                            </div>
                            <div id="familyFieldsContainer"></div> --}}
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 1(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember1Name" id="familyMember1Name" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row">
                                    <input type="text" name="familyMember1Phone" id="familyMember1Phone" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember1Relation" id="familyMember1Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Son">Son</option>
                                        <option value="Sister">Daughter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 2(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember2Name" id="familyMember2Name" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row">
                                    <input type="text" name="familyMember2Phone" id="familyMember2Phone" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember2Relation" id="familyMember2Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 3(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember3Name" id="familyMember3Name" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row">
                                    <input type="text" name="familyMember3Phone" id="familyMember3Phone" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember3Relation" id="familyMember3Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 4(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember4Name" id="familyMember4Name" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row">
                                    <input type="text" name="familyMember4Phone" id="familyMember4Phone" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember4Relation" id="familyMember4Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 5(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember5Name" id="familyMember5Name" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row">
                                    <input type="text" name="familyMember5Phone" id="familyMember5Phone" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember5Relation" id="familyMember5Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother">Mother</option>
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Business Informations</h1>
                            <div class="frm_row">
                                <label>Business Name</label>
                                <input type="text" name="businessName" />
                            </div>
                            <div class="frm_row">
                                <label>Premises No.</label>
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
                                <input type="text" name="dealsIn" placeholder="Office/Business"/>
                            </div>
                            <div class="frm_row">
                                <label>Phone No.</label>
                                <input type="number" name="Phone_O" placeholder="Office/Business"/>
                            </div>
                            <div class="frm_row">
                                <label>Mobile No.</label>
                                <input type="number" name="Mobile_O" placeholder="Office/Business"/>
                            </div>
                            <div class="frm_row">
                                <label>Fax No.</label>
                                <input type="number" name="businessFaxNo" placeholder="Office/Business"/>
                            </div>
                        </div>

                        <div class="btn_frm">

                            <a href="javascript:void(0);" class="cmn_btn gre" id="backBtn">Back</a>
                            <a href="javascript:void(0);" class="cmn_btn" id="nextBtn">Next</a>
                            <a href="javascript:void(0);" class="cmn_btn gre" id="resetBtn"
                                style="display: none;">Reset</a>
                                
                                <input type="submit" class="cmn_btn" id="submitBtn" style="display: none;" value="Submit">
                            </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

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
    </script>

{{-- <script>
    function generateFamilyFields() {
        const numOfFamilyMembers = parseInt(document.getElementById("familyDetails").value);
        const familyFieldsContainer = document.getElementById("familyFieldsContainer");
    
        // Clear the container to avoid duplicate fields
        familyFieldsContainer.innerHTML = "";
    
        if (!isNaN(numOfFamilyMembers) && numOfFamilyMembers > 0) {
            for (let i = 1; i <= numOfFamilyMembers; i++) {
                // Create a new div for each family member
                const memberDiv = document.createElement("div");
                memberDiv.classList.add("frm_row");
    
                // Create name label and input
                const nameLabel = document.createElement("label");
                nameLabel.textContent = `Family Member ${i} `;
                const nameInput = document.createElement("input");
                nameInput.type = "text";
                nameInput.name = `familyMember${i}Name`;
                nameInput.placeholder = "Enter name";
    
                // Create phone label and input
                const phoneLabel = document.createElement("label");
                phoneLabel.textContent = `Family Member ${i} `;
                const phoneInput = document.createElement("input");
                phoneInput.type = "text";
                phoneInput.name = `familyMember${i}Phone`;
                phoneInput.placeholder = "Enter phone number";
    
                // Append everything to memberDiv
                memberDiv.appendChild(nameLabel);
                memberDiv.appendChild(nameInput);
                memberDiv.appendChild(phoneLabel);
                memberDiv.appendChild(phoneInput);
    
                // Append memberDiv to the container
                familyFieldsContainer.appendChild(memberDiv);
            }
        }
    }
</script> --}}
@endsection


