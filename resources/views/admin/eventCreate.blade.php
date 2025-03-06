@extends('layout.adminapp')


@section('content')
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css"> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        .ck-powered-by {
            display: none !important;
        }

        #upload-demo {
            width: 250px;
            height: 250px;
            padding-bottom: 25px;
        }

        #image {
            max-width: 100%;
        }

        .modal-content {
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;
        }

        .modal-body {
            padding: 0;
        }

        #item-img-output {
            width: 150px;
        }


        .image-upload>input {
            display: none;
        }

        .file_input {
            box-sizing: border-box;
            height: 100%;
            width: 100%;
            border: 2px solid #bce9d8;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 150ms ease;
            background-color: #bce9d8 !important;
            height: 50px;
            padding-top: 15px;
        }

        .file_input img {
            margin: auto;
            display: inline-block;
            margin-right: 5px;
            color: #00c179;
            opacity: 1;
        }

        .image-upload {
            margin: 20px 0;
        }

        .image-upload.upld_logo_img .file_input {
            background-color: transparent !important;
            border: 10px solid #ffeaca;
            border-bottom: 25px solid #ffeaca;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            margin-right: auto;
            height: auto;
            width: 50%;
            text-align: center;
            cursor: pointer;
        }

        .image-upload.upld_logo_img .file_input img {
            width: 50%;
        }

        .image-upload.upld_logo_img {
            text-align: left;
            margin-top: 10px;
        }

        .image-upload.upld_logo_img h5 {
            padding-bottom: 10px;
            font-size: 15px;
        }

        .svg-inline--fa.fa-indian-rupee-sign {
            height: 18px !important;
            width: 100px !importants;
        }

        .packageCostIcon_container {
            position: absolute;
            left: 2px;
            top: 19px;
            z-index: 1;

        }

        .cf_tp_txt_mn.packageCost_container {
            position: relative
        }


        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure it's on top */
        }

        #loader {
            border: 8px solid #ffeaca;
            border-radius: 50%;
            border-top: 8px solid #990000;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #time {
            width: 50%;
            height: 70%;
            font-size: 2rem;
        }

        /*Ckeditor CSS*/

        .ck-editor {
            width: 100%;
            /* Make the editor responsive */
            min-height: 250px;
            /* Set a minimum height for the editor */
            border: 1px solid #ccc;
            /* Default border */
            border-radius: 10px;
            /* Rounded corners */
            transition: border-color 0.3s ease;
            /* Smooth transition for border color */
        }

        /* Change the appearance of the editor when focused */
        .ck-focused {
            border-color: #007bff;
            /* Change border color when focused */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Add shadow effect */
        }

        /* Customize toolbar appearance */
        .ck-toolbar {
            background-color: #f8f9fa;
            /* Light background for the toolbar */
            border: 1px solid #ced4da;
            /* Border for the toolbar */
            border-radius: 4px;
            /* Rounded corners */
            margin-bottom: 5px;
            /* Space between toolbar and editor */
        }

        /* Style for the toolbar items */
        .ck-toolbar .ck-button {
            color: #495057;
            /* Default color for buttons */
        }

        /* Hover effect for toolbar buttons */
        .ck-toolbar .ck-button:hover {
            background-color: #e2e6ea;
            /* Light gray on hover */
        }

        /* Active button styling */
        .ck-toolbar .ck-button.ck-on {
            background-color: #007bff;
            /* Blue background for active buttons */
            color: #fff;
            /* White text for active buttons */
        }

        /* Customize the appearance of the editable area */
        .ck-editor__editable {
            padding: 10px;
            /* Add padding for better text spacing */
            min-height: 200px;
            /* Set minimum height for editable area */
            font-size: 14px;
            /* Font size for the text */
            line-height: 1.5;
            /* Line height for better readability */
        }

        /* Customize font family and size in the editor */
        .ck-editor__editable {
            font-family: Arial, Helvetica, sans-serif;
            /* Default font */
        }

        /* Customize the appearance of block quotes */
        .ck-blockquote {
            border-left: 4px solid #007bff;
            /* Left border for block quotes */
            padding-left: 10px;
            /* Padding for text */
            color: #6c757d;
            /* Color for quote text */
            background-color: #f8f9fa;
            /* Light background for quotes */
            margin: 10px 0;
            /* Margin for spacing */
        }
        .editor.south_jst ul,.south_jst.news_detailss  ul{
        list-style-type: disc !important; 
        margin-left: 20px !important;
        list-style: disc !important; 
        }
        ul{
        list-style: disc !important; 
        }
        .editor.south_jst ol ,.south_jst.news_detailss .frm_row ol{
        list-style-type: decimal !important; 
        margin-left: 20px !important;
        }
 
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .ck-editor {
                min-height: 200px;
                /* Adjust min-height for smaller screens */
            }
        }
    
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="otr">
    <div class="container">
      <div class="south_jst editor">
        <div class="mul_form">
          <div class="multi_top_dir">Create Event</div>
            <form action="{{ route('admin.insertEvent') }}" method="POST" id="dynamic-form" enctype="multipart/form-data" >
                    @csrf
                    <div class="frm_cnt" id="frm_cnt1">
                        <div class="frm_row">
                            <label>Event Name</label>
                            <input type="text" name="title" id="title" placeholder="Enter title" />
                            <small class="error-message" id="title_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Event Description</label>
                            <textarea class="mt_dscrb_bx" id="description" name="description" placeholder="Enter description" style="width: 100%;"></textarea>
                            <small class="error-message" id="description_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Upload Event Images</label>
                            <input type="file" class="inpt" id="eventImages" name="eventImages[]" multiple accept="image/*">
                            <div id="eventImagesContainer" style="margin-top: 20px;"></div>
                            <small class="error-message" id="eventImages_error"></small>
                            <input type="hidden" id="bannerImage" name="bannerImage">
                        </div>
                        <div class="frm_row">
                            <label>Start Date</label>
                            <input type="date" class="inpt dates" id="startDate" name="startDate" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="startDate_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Start Time</label>
                            <input type="time" class="inpt dates" id="startTime" name="startTime" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="startTime_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>End Date</label>
                            <input type="date" class="inpt dates" id="endDate" name="endDate" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="endDate_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>End Time</label>
                            <input type="time" class="inpt dates" id="endTime" name="endTime" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="endTime_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Event Organize for</label>
                            <select name="allowedVistors" id="allowedVistors">
                                <option value="All">All Members</option>
                                <option value="FOUNDER">FOUNDER</option>
                                <option value="PATRON">PATRON</option>
                                <option value="LIFE">LIFE</option>
                            </select>
                        </div>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            
            let editorInstance; // Store CKEditor instance

            ClassicEditor.create(document.querySelector("#description"), {
                    ckfinder: {
                        uploadUrl: "https://form.perfectcreate.com/upload",
                    },
                    toolbar: {
                        items: [
                            "undo",
                            "redo",
                            "bold",
                            "italic",
                            "link",
                            "bulletedList",
                            "numberedList",
                            "|",
                            "indent",
                            "outdent",
                            "|",
                            "blockQuote",
                            "insertTable",
                            "mediaEmbed",
                        ],
                    },
                    image: {
                        toolbar: [
                            "imageTextAlternative",
                            "imageStyle:full",
                            "imageStyle:side",
                        ],
                    },
                })
                .then((editor) => {
                    editorInstance = editor;

                    // Listen to changes in CKEditor and validate in real-time
                    editor.model.document.on("change:data", () => {
                        validateField("#description", "#description_error", "Event description is required.", editorInstance.getData());
                    });
                })
                .catch((error) => {
                    console.error("Error initializing editor:", error);
                });

            // Function to validate fields in real-time
            function validateField(input, errorSelector, message, customValue = null) {
                let value = customValue !== null ? customValue.trim() : $(input).val().trim();
                if (value === "") {
                    $(errorSelector).text(message);
                    return false;
                } else {
                    $(errorSelector).text(""); // Clear error if valid
                    return true;
                }
            }

            // Real-time validation for input fields
            $("#title").on("input", function () {
                validateField("#title", "#title_error", "Event name is required.");
            });

            $("#startDate").on("change", function () {
                validateField("#startDate", "#startDate_error", "Start date is required.");
            });

            $("#startTime").on("change", function () {
                validateField("#startTime", "#startTime_error", "Start time is required.");
            });

            $("#eventImages").on("change", function () {
                if (this.files.length === 0) {
                    $("#eventImages_error").text("At least one event image is required.");
                } else {
                    $("#eventImages_error").text(""); // Clear error if valid
                }
            });

            // Form validation on submit
            $("#dynamic-form").submit(function (event) {
                let isValid = true;

                // Validate all fields before submission
                if (!validateField("#title", "#title_error", "Event name is required.")) isValid = false;
                if (!validateField("#description", "#description_error", "Event description is required.", editorInstance.getData())) isValid = false;
                if (!validateField("#startDate", "#startDate_error", "Start date is required.")) isValid = false;
                if (!validateField("#startTime", "#startTime_error", "Start time is required.")) isValid = false;
                if ($("#eventImages")[0].files.length === 0) {
                    $("#eventImages_error").text("At least one event image is required.");
                    isValid = false;
                } else {
                    $("#eventImages_error").text(""); // Clear error if valid
                }

                // Prevent form submission if invalid
                if (!isValid) {
                    event.preventDefault();
                }
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            let uploadedFiles = []; // Array to store file objects
            let bannerFile = null; // Banner image file object

            $("#eventImages").on("change", function (e) {
                let files = e.target.files;

                if (files.length > 0) {
                    $.each(files, function (index, file) {
                        let reader = new FileReader();
                        let uniqueId = Date.now() + index;

                        reader.onload = function (e) {
                            let imageUrl = e.target.result;

                            uploadedFiles.push({ id: uniqueId, file: file });
                            console.log(uploadedFiles);

                            if (!bannerFile) {
                                bannerFile = file; // Set first file as default banner
                                updateBannerFileInput();
                            }

                            $("#eventImagesContainer").append(`
                                <div class="image-box" id="img-${uniqueId}" style="position: relative; width: 100px;">
                                    <img src="${imageUrl}" style="width: 100px; height: 100px; border-radius: 5px;">
                                   <div class="ne_btnn">
                                   <button class="pin-btn nw_bt" data-id="${uniqueId}" data-file-index="${uploadedFiles.length - 1}" >📌</button>
                                   <button class="remove-btn nw_bt" data-id="${uniqueId}" >✖</button>
                                   </div>
                                </div>
                            `);

                            updateEventImagesInput();
                        };

                        reader.readAsDataURL(file);
                    });
                }
            });

            $(document).on("click", ".remove-btn", function () {
                let id = $(this).data("id");
                uploadedFiles = uploadedFiles.filter(item => item.id !== id);

                if (bannerFile && bannerFile.id === id) {
                    bannerFile = uploadedFiles.length > 0 ? uploadedFiles[0].file : null;
                    updateBannerFileInput();
                }

                $("#img-" + id).remove();
                updateEventImagesInput();
            });
            $(document).on("click", ".pin-btn", function () {
                let fileIndex = $(this).data("file-index");
                let id = $(this).data("id"); // Unique ID for the image container
                bannerFile = uploadedFiles[fileIndex].file;

                // Reset all pin buttons and remove the overlay from every image
                $(".pin-btn").prop("disabled", false).css("background", "#ffffff");
                $("#eventImagesContainer img").removeClass("overlay-image");

                // Disable the current pin button and add overlay to its image only
                $(this).prop("disabled", true).css("background", "gray");
                $("#img-" + id + " img").addClass("overlay-image");

                updateBannerFileInput();
            });

            function updateEventImagesInput() {
                let dataTransfer = new DataTransfer();
                uploadedFiles.forEach(item => dataTransfer.items.add(item.file));

                let input = document.getElementById("eventImages");
                input.files = dataTransfer.files;
            }

            function updateBannerFileInput() {
                let bannerInput = $("#bannerImageInput");

                if (bannerInput.length === 0) {
                    bannerInput = $('<input>', {
                        type: "file",
                        name: "bannerImage",
                        id: "bannerImageInput",
                        style: "display: none"
                    });
                    $("form").append(bannerInput);
                }

                let bannerDataTransfer = new DataTransfer();
                if (bannerFile) {
                    bannerDataTransfer.items.add(bannerFile);
                }

                bannerInput[0].files = bannerDataTransfer.files;
            }
        });

    </script>

    
@endsection