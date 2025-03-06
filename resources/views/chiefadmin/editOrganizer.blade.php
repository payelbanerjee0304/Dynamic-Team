@extends('layout.chiefadminapp')
@section('content')
<div class="otr">
    <div class="container">
      <div class="south_jst editor">
        <div class="mul_form">
          <div class="multi_top_dir">Create Organizer</div>
            <form action="{{ route('chiefadmin.updateOrganizer') }}" method="POST" id="dynamic-form" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="organizerId" id="organizerId" value="{{ $organizers['_id'] }}">
                    <div class="frm_cnt" id="frm_cnt1">
                        <div class="frm_row">
                            <label>Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter name" value="{{ $organizers['name'] }}" />
                            <small class="error-message" id="name_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter email" value="{{ $organizers['emailId'] }}" />
                            <small class="error-message" id="email_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter Phone" value="{{ $organizers['phoneNumber'] }}" />
                            <small class="error-message" id="phone_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Address</label>
                            <textarea class="mt_dscrb_bx" name="address" id="address" style="width: 100%;" placeholder="Enter Address">{{ $organizers['address'] }}</textarea>
                            <small class="error-message" id="address_error"></small>
                        </div>
                        
                        <div class="frm_row">
                            <label>Logo Image</label>
                            <input type="file" class="inpt" id="logoImage" name="logoImage" accept="image/*" >
                            <img id="logoPreview" src="{{$organizers['headerLogo']}}" height="50" alt="Logo Preview">
                            <small class="error-message" id="logoImage_error"></small>
                        </div>
                        {{-- <div class="frm_row">
                            <label>Sidebar Image</label>
                            <input type="file" class="inpt" id="sidebarImage" name="sidebarImage" accept="image/*">
                            <small class="error-message" id="sidebarImage_error"></small>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Function to validate required fields
        function validateField(field, errorMessage) {
            const value = field.val().trim();
            const errorElement = $("#" + field.attr("id") + "_error");
            if (!value) {
                errorElement.text(errorMessage);
                field.addClass("error-border");
                return false;
            } else {
                errorElement.text("");
                field.removeClass("error-border");
                return true;
            }
        }
    
        // Function to validate email
        function validateEmail(field) {
            const value = field.val().trim();
            const errorElement = $("#" + field.attr("id") + "_error");
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email regex
            if (!value) {
                errorElement.text("Email is required.");
                field.addClass("error-border");
                return false;
            } else if (!emailRegex.test(value)) {
                errorElement.text("Please enter a valid email address.");
                field.addClass("error-border");
                return false;
            } else {
                errorElement.text("");
                field.removeClass("error-border");
                return true;
            }
        }
    
        // Function to restrict phone input to 10 digits
        $("#phone").on("input", function () {
            let value = $(this).val();
            // Remove non-digit characters
            value = value.replace(/\D/g, "");
            // Limit to 10 digits
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            $(this).val(value);
    
            // Validate phone field
            validateField($(this), "Phone is required.");
        });
    
        // Validate email on input
        $("#email").on("input", function () {
            validateEmail($(this));
        });
    
        // Validate fields on input
        $("#name").on("input", function () {
            validateField($(this), "Name is required.");
        });
    
        $("#address").on("input", function () {
            validateField($(this), "Address is required.");
        });

        $("#logoImage").on("change", function (event) {
            const file = event.target.files[0];
            const logoPreview = $("#logoPreview");
    
            if (file) {
                // Validate file type (only images)
                const validTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
                if (!validTypes.includes(file.type)) {
                    alert("Please select a valid image file (JPEG, PNG, GIF, or WEBP).");
                    $(this).val(""); // Clear the input
                    return;
                }
    
                // Create a URL for the selected file and set it as the image source
                const reader = new FileReader();
                reader.onload = function (e) {
                    logoPreview.attr("src", e.target.result); // Update image preview
                };
                reader.readAsDataURL(file);
            } else {
                // Reset to original image if no file is selected
                logoPreview.attr("src", "{{$organizers['headerLogo']}}");
            }
        });
    
    
        // Validate on form submit
        $("#dynamic-form").on("submit", function (e) {
            let isValid = true;
    
            // Validate all fields
            isValid &= validateField($("#name"), "Name is required.");
            isValid &= validateEmail($("#email"));
            isValid &= validateField($("#phone"), "Phone is required.");
            isValid &= validateField($("#address"), "Address is required.");
    
            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Handle file input change
        
    });
    </script>
@endsection