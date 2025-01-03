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
                    {{-- <a href="{{route('logout')}}"><button class="btn btn-info">Logout</button></a> --}}
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

                        <div class="frm_cnt">
                            <h1>Membership Informations</h1>
                            <div class="frm_row">
                                <label>Membership No.</label>
                                <input type="text" id="memberNumber" name="Membership_No"
                                    value="{{ $member['Membership_No'] }}" readonly />
                            </div>
                            <div class="frm_row">
                                <label>Member of Sabha</label>
                                <div class="check">
                                    <span> <input type="radio" name="Members_Type"
                                    value="FOUNDER" @if($member['Members_Type']=="FOUNDER") checked @endif /> <label>
                                            Founder</label></span>
                                    <span> <input type="radio" name="Members_Type"
                                    value="PATRON" @if($member['Members_Type']=="PATRON") checked @endif /> <label>
                                            Patron</label> </span>
                                    <span> <input type="radio" name="Members_Type"
                                    value="LIFE" @if($member['Members_Type']=="LIFE") checked @endif />
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
                                <label>Father/Husband’s Name</label>
                                <input type="text" name="Son_Daughter_of" value="{{ $member['Son_Daughter_of'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Spouse Name</label>
                                <input type="text" name="Spouse" value="{{ $member['Spouse'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Do you have Terpanth Card?</label>
                                <div class="check">
                                    <span><input type="radio" value="Yes" name="hasTerapanthCard" @if($member['hasTerapanthCard']=="Yes") checked @endif /> <label>
                                            Yes</label></span>
                                    <span><input type="radio" value="No" name="hasTerapanthCard" @if($member['hasTerapanthCard']=='No') checked @endif/> <label>
                                            No</label></span>
                                </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Personal Informations</h1>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Birth</label>
                                    <input type="date" name="DOB" id="dob" onchange="calculateAge()" value="{{ $member['DOB'] }}"  max="{{ date('Y-m-d', strtotime('-18 years')) }}" />
                                </div>
                                <div class="frm_row">
                                    <label>Age</label>
                                    <input type="text" name="age" id="age" value="{{ $member['age'] }}" readonly />
                                </div>
                            </div>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Marriage</label>
                                    <input type="date" name="DOM" value="{{ $member['DOM'] }}" max="{{ now()->format('Y-m-d') }}" />
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
                                <input type="number" name="Mobile" value="{{ $member['Mobile'] }}" readonly/>
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

                        <div class="frm_cnt ">
                            <h1>Residential Informations</h1>
                            <div class="frm_row">
                                <label>Premises No.</label>
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
                            {{-- <div class="frm_row">
                                <label>Number of Family Members</label>
                                <input type="text" name="familyDetails" id="familyDetails" onkeyup="generateFamilyFields()" value="{{ $member['numOfFamilyMembers'] }}" />
                            </div> --}}
                            {{-- <div id="familyFieldsContainer"></div> --}}
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 1(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember1Name" id="familyMember1Name" value="{{ $member['familyMember1Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember1Phone" id="familyMember1Phone" value="{{ $member['familyMember1Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember1Relation" id="familyMember1Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember1Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember1Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember1Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 2(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember2Name" id="familyMember2Name" value="{{ $member['familyMember2Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember2Phone" id="familyMember2Phone" value="{{ $member['familyMember2Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember2Relation" id="familyMember2Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember2Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember2Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember2Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 3(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember3Name" id="familyMember3Name" value="{{ $member['familyMember3Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember3Phone" id="familyMember3Phone" value="{{ $member['familyMember3Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember3Relation" id="familyMember3Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember3Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember3Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember3Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 4(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember4Name" id="familyMember4Name" value="{{ $member['familyMember4Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember4Phone" id="familyMember4Phone" value="{{ $member['familyMember4Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember4Relation" id="familyMember4Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember4Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember4Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember4Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 5(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember5Name" id="familyMember5Name" value="{{ $member['familyMember5Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember5Phone" id="familyMember5Phone" value="{{ $member['familyMember5Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember5Relation" id="familyMember5Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember5Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember5Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember5Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="frm_row nw_ad_frm_lb">
                            <label>Family Member 6(Optional)</label>
                            </div>
                            <div class="frm_d_div add_form nw_ad_frm fmly_frm">
                                <div class="frm_row">
                                
                                    <input type="text" name="familyMember6Name" id="familyMember6Name" value="{{ $member['familyMember6Name'] }}" placeholder="Enter Name"/>
                                </div>
                                <div class="frm_row_rltn">
                                <div class="frm_row">
                                    <input type="number" name="familyMember6Phone" id="familyMember6Phone" value="{{ $member['familyMember6Phone'] }}" placeholder="Enter Phone" />
                                </div>
                                <div class="frm_row">
                                    <select name="familyMember6Relation" id="familyMember6Relation">
                                        <option value="">Select Relation</option>
                                        <option value="Mother"{{ $member['familyMember6Relation'] == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Son"{{ $member['familyMember6Relation'] == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter"{{ $member['familyMember6Relation'] == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Business Informations</h1>
                            <div class="frm_row">
                                <label>Business Name</label>
                                <input type="text" name="businessName" value="{{$member['businessName']}}" />
                            </div>
                            <div class="frm_row">
                                <label>Premises No.</label>
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
                                <input type="text" name="dealsIn" value="{{ $member['dealsIn'] }}" placeholder="Office/Business" />
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
    const existingFamilyData = @json($member); // This retrieves the entire member object

    function generateFamilyFields() {
        // Determine the number of family members from existing data or the input value
        let numOfFamilyMembers = parseInt(document.getElementById("familyDetails").value);
        
        // If existing data is available but numOfFamilyMembers is not set, use existing data length
        if (isNaN(numOfFamilyMembers) || numOfFamilyMembers < 1) {
            numOfFamilyMembers = Object.keys(existingFamilyData).length / 3; // assuming each member has 3 fields
            document.getElementById("familyDetails").value = numOfFamilyMembers;
        }

        const familyFieldsContainer = document.getElementById("familyFieldsContainer");
        familyFieldsContainer.innerHTML = ""; // Clear the container

        if (numOfFamilyMembers > 0) {
            for (let i = 1; i <= numOfFamilyMembers; i++) {
                const memberDiv = document.createElement("div");
                memberDiv.classList.add("frm_row");

                // Create a header for each family member
                const header = document.createElement("h3");
                header.textContent = `Family Member ${i} Details`;
                memberDiv.appendChild(header);

                // Name input
                const nameInput = document.createElement("input");
                nameInput.type = "text";
                nameInput.name = `familyMember${i}Name`;
                nameInput.placeholder = "Enter name";
                if (existingFamilyData[`familyMember${i}Name`]) {
                    nameInput.value = existingFamilyData[`familyMember${i}Name`];
                }

                // Phone input
                const phoneInput = document.createElement("input");
                phoneInput.type = "text";
                phoneInput.name = `familyMember${i}Phone`;
                phoneInput.placeholder = "Enter phone number";
                if (existingFamilyData[`familyMember${i}Phone`]) {
                    phoneInput.value = existingFamilyData[`familyMember${i}Phone`];
                }

                // Relation dropdown
                const relationSelect = document.createElement("select");
                relationSelect.name = `familyMember${i}Relation`;
                const relations = ["Select Relation", "Brother", "Sister", "Uncle", "Aunt"];
                relations.forEach(relation => {
                    const option = document.createElement("option");
                    option.value = relation;
                    option.textContent = relation;
                    if (existingFamilyData[`familyMember${i}Relation`] === relation) {
                        option.selected = true;
                    }
                    relationSelect.appendChild(option);
                });

                // Append inputs to memberDiv
                memberDiv.appendChild(nameInput);
                memberDiv.appendChild(phoneInput);
                memberDiv.appendChild(relationSelect);

                // Append memberDiv to the container
                familyFieldsContainer.appendChild(memberDiv);
            }
        }
    }

    // Populate fields on page load
    window.onload = function() {
        generateFamilyFields();
    };
</script> --}}


@endsection
