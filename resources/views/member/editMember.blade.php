@extends('layouts.layout')

@section('content')
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

                    <form action="{{ route('updateMember') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="memberId" value="{{ $member['_id'] }}">

                        <div class="frm_cnt">
                            <h1>Membership Informations</h1>
                            <div class="frm_row">
                                <label>Membership No.</label>
                                <input type="text" id="memberNumber" name="Membership_No"
                                    value="{{ $member['Membership_No'] }}" />
                            </div>

                            <div class="frm_row">
                                <label>Member of Sabha</label>
                                <div class="check">
                                    <span> <input type="checkbox" value="Founder" name="Members_Type"
                                            {{ $member['Members_Type'] == 'FOUNDER' ? 'checked' : '' }} /> <label>
                                            Founder</label></span>
                                    <span> <input type="checkbox" value="Patron" name="memberType"
                                            {{ $member['Members_Type'] == 'PATRON' ? 'checked' : '' }} /> <label>
                                            Patron</label> </span>
                                    <span> <input type="checkbox" value="Life" name="memberType"
                                            {{ $member['Members_Type'] == 'LIFE' ? 'checked' : '' }} />
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
                                    <span><input type="radio" value="Yes" name="hasTerapanthCard" /> <label>
                                            Yes</label></span>
                                    <span><input type="radio" value="No" name="hasTerapanthCard" /> <label>
                                            No</label></span>
                                </div>
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Personal Informations</h1>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Birth</label>
                                    <input type="date" name="DOB" value="{{ $member['DOB'] }}" />
                                </div>
                                <div class="frm_row">
                                    <label>Age</label>
                                    <input type="text" name="age" />
                                </div>
                            </div>
                            <div class="frm_d_div add_form">
                                <div class="frm_row">
                                    <label>Date of Marriage</label>
                                    <input type="date" name="DOM" value="{{ $member['DOM'] }}" />
                                </div>
                                <div class="frm_row">
                                    <label>Blood Group</label>
                                    <input type="text" name="bloodGroup" />
                                </div>
                            </div>
                            <div class="frm_d_div">
                                <div class="frm_row">
                                    <label>Qualification</label>
                                    <input type="text" name="Qualification" value="{{ $member['Qualification'] }}" />
                                </div>
                                <div class="frm_row">
                                    <label>Occupation</label>
                                    <input type="text" name="Occupation" value="{{ $member['Occupation'] }}" />
                                </div>
                            </div>

                            <div class="frm_row">
                                <label>Mobile No.</label>
                                <input type="text" name="Mobile" value="{{ $member['Mobile'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Alternative Mobile No.</label>
                                <input type="text" name="alternateNumber" value="" />
                            </div>
                            <div class="frm_row">
                                <label>Email</label>
                                <input type="text" name="Email_ID" value="{{ $member['Email_ID'] }}" />
                            </div>



                            <div class="frm_row">
                                <label>Upload Photo</label>
                                <div class="task_dD attach">
                                    <div id="dropArea" class="drag-area">
                                        <p>Drag file to upload</p>
                                    </div>
                                    <img id="imagePreview" src="{{ asset('images/upload_img.png') }}" alt="Preview Img" />
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
                                <label>Residence Address</label>
                                <textarea name="residenceAddress"> {{ $member['Residence1'] }} {{ $member['Residence2'] }} {{ $member['Residence3'] }} {{ $member['Residence4'] }} </textarea>
                            </div>
                            <div class="frm_row">
                                <label>Pincode</label>
                                <input type="text" name="Res_PINCODE" value="{{ $member['Res_PINCODE'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Native Place</label>
                                <input type="text" name="Native_Place" value="{{ $member['Native_Place'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Phone No.</label>
                                <input type="text" name="Phone" value="{{ $member['Phone'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Family Members/Details</label>
                                <input type="text" name="familyDetails" />
                            </div>
                        </div>

                        <div class="frm_cnt">
                            <h1>Business Informations</h1>
                            <div class="frm_row">
                                <label>Business Name</label>
                                <input type="text" name="businessName" />
                            </div>
                            <div class="frm_row">
                                <label>Business Address</label>
                                <textarea name="businessAddress"> {{ $member['Office-1'] }} {{ $member['Office-2'] }} {{ $member['Office-3'] }} {{ $member['Office-4'] }} </textarea>
                            </div>
                            <div class="frm_row">
                                <label>Pincode</label>
                                <input type="text" name="PINCODE" value="{{ $member['PINCODE'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Phone No.</label>
                                <input type="text" name="Phone_O" value="{{ $member['Phone_O'] }}" />
                            </div>
                            <div class="frm_row">
                                <label>Fax No.</label>
                                <input type="text" name="businessFaxNo" />
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
@endsection
