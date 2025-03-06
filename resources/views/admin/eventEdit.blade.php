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
        .image-item{
            position: relative;
        }
        .pin-btn.nw_bt{
            position: absolute;
            top: 0;
        }
        .remove-btn.nw_bt{
            position: absolute;
            top: 0;
            right: 0;
        }
    
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="otr">
    <div class="container">
      <div class="south_jst editor">
        <div class="mul_form">
          <div class="multi_top_dir">Edit Event</div>
            <form action="{{ route('admin.updateEvent', $event->id) }}" method="POST" id="dynamic-form" enctype="multipart/form-data">
                @csrf
        
                <div class="frm_cnt" id="frm_cnt1">
                    <div class="frm_row">
                        <label>Event Name</label>
                        <input type="text" name="title" id="title" value="{{ $event->title }}" placeholder="Enter title" />
                        <small class="error-message" id="title_error"></small>
                    </div>
                    <div class="frm_row">
                        <label>Event Description</label>
                        <textarea class="mt_dscrb_bx" id="description" name="description" placeholder="Enter description" style="width: 100%;">{{ $event->description }}</textarea>
                        <small class="error-message" id="description_error"></small>
                    </div>
                    <div class="frm_row">
                        <label>Upload Event Images</label>
                        @php
                            if (!function_exists('cleanFilename')) {
                                function cleanFilename($url) {
                                    $filename = basename(parse_url($url, PHP_URL_PATH));
                                    return preg_replace('/^\d+_/', '', $filename); 
                                }
                            }
                        @endphp
                        <input type="file" class="inpt" id="eventImages" name="eventImages[]" multiple accept="image/*">
                        <div id="eventImagesContainer" style="margin-top: 20px;">
                            @foreach($event->eventImages as $image)
                                <div class="image-box existing-image" id="img-{{ $loop->index }}" style="position: relative; width: 100px;">
                                    <img src="{{ $image }}" style="width: 100px; height: 100px; border-radius: 5px;">
                                    <div class="ne_btnn">
                                        <button type="button" class="pin-btn nw_bt" data-url="{{ $image }}" style="background-color:{{ cleanFilename($image) == cleanFilename($event->bannerImage) ? 'gray' : 'white' }}">📌</button>
                                        <button type="button" class="remove-btn nw_bt" data-url="{{ $image }}">✖</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="error-message" id="eventImages_error"></small>
                        <input type="hidden" id="bannerImage" name="bannerImage" value="{{ $event->bannerImage }}">
                        <input type="hidden" id="deletedImages" name="deletedImages">
                    </div>
                    <div class="frm_row">
                        <label>Start Date</label>
                        <input type="date" class="inpt dates" id="startDate" name="startDate" value="{{ \Carbon\Carbon::createFromFormat('Ymd', $event->startDate)->format('Y-m-d') }}" />
                        <small class="error-message" id="startDate_error"></small>
                    </div>
                    <div class="frm_row">
                        <label>Start Time</label>
                        <input type="time" class="inpt dates" id="startTime" name="startTime" value="{{ $event->startTime }}" />
                        <small class="error-message" id="startTime_error"></small>
                    </div>
                    <div class="frm_row">
                        <label>End Date</label>
                        <input type="date" class="inpt dates" id="endDate" name="endDate" value="{{ \Carbon\Carbon::createFromFormat('Ymd', $event->endDate)->format('Y-m-d') }}" />
                        <small class="error-message" id="endDate_error"></small>
                    </div>
                    <div class="frm_row">
                        <label>End Time</label>
                        <input type="time" class="inpt dates" id="endTime" name="endTime" value="{{ $event->endTime }}" />
                        <small class="error-message" id="endTime_error"></small>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>



    <script>
        let editorInstance;

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
                        // "imageUpload",
                    ],
                },
                image: {
                    toolbar: [
                        "imageTextAlternative", // Alternative text for accessibility
                        "imageStyle:full",      // Full-width image
                        "imageStyle:side",      // Side-aligned image
                    ],
                },
                // Optionally include additional configuration settings here
            })
            .then((editor) => {
                editorInstance = editor;
                // console.log('Editor was initialized', editor);

                // Listen to the 'change' event on the CKEditor instance
                editorInstance.model.document.on('change:data', () => {
                    validateForm();
                });
            })
            .catch((error) => {
                console.error('Error initializing editor:', error);
            });



        const validateForm = () => {
            const checkAllFields = [
                

            ];
            return checkAllFields.every((value) => value === true);
        };

    </script>
    <script>
        $(document).ready(function () {
            let uploadedFiles = [];
            let deletedImages = [];
            let bannerFile = $("#bannerImage").val();
    
            // Handle new image upload
            $("#eventImages").on("change", function (e) {
                let files = e.target.files;
                if (files.length > 0) {
                    $.each(files, function (index, file) {
                        let reader = new FileReader();
                        let uniqueId = Date.now() + index;
    
                        reader.onload = function (e) {
                            let imageUrl = e.target.result;
                            uploadedFiles.push({ id: uniqueId, file: file });
    
                            $("#eventImagesContainer").append(
                                `<div class="image-box new-image" id="img-${uniqueId}" style="position: relative; width: 100px;">
                                    <img src="${imageUrl}" style="width: 100px; height: 100px; border-radius: 5px;">
                                    <div class="ne_btnn">
                                        <button type="button" class="pin-btn nw_bt" data-id="${uniqueId}">📌</button>
                                        <button type="button" class="remove-btn nw_bt" data-id="${uniqueId}">✖</button>
                                    </div>
                                </div>`
                            );
                            updateBannerImage(); // Check and update bannerImage if needed
                        };
    
                        reader.readAsDataURL(file);
                    });
                }
            });
    
            // Handle removing existing images
            $(document).on("click", ".remove-btn", function () {
                let url = $(this).data("url");
                let id = $(this).data("id");
    
                // Remove existing image
                if (url) {
                    deletedImages.push(url);
                    $("#deletedImages").val(JSON.stringify(deletedImages));
                }
    
                // Remove new image from uploadedFiles array
                if (id) {
                    uploadedFiles = uploadedFiles.filter(item => item.id !== id);
                }
    
                $(this).closest(".image-box").remove();
                updateBannerImage(); // Check and update bannerImage if needed
            });
    
            // Handle pinning images
            $(document).on("click", ".pin-btn", function () {
                let url = $(this).data("url");
                let id = $(this).data("id");
    
                if (url) {
                    // Set existing image as banner
                    $("#bannerImage").remove();
                    $(".frm_row").append(`<input type="hidden" id="bannerImage" name="bannerImage" value="${url}">`);
                } else if (id) {
                    // Set new image as banner
                    let fileIndex = uploadedFiles.findIndex(item => item.id === id);
                    if (fileIndex !== -1) {
                        let file = uploadedFiles[fileIndex].file;
                        $("#bannerImage").remove();
    
                        let fileInput = $('<input>', {
                            type: 'file',
                            name: 'bannerImage',
                            id: 'bannerImage',
                            class: 'inpt',
                            style: 'display: none;'
                        })[0];
    
                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;
    
                        $(".frm_row").append(fileInput);
                    }
                }
    
                // Update UI styles
                $(".pin-btn").prop("disabled", false).css("background", "#ffffff");
                $(".image-box img").removeClass("overlay-image");
    
                $(this).prop("disabled", true).css("background", "gray");
                $(this).closest(".image-box").find("img").addClass("overlay-image");
            });
    
            // Function to update banner image if deleted
            function updateBannerImage() {
                let remainingImages = $(".image-box img").map(function () {
                    return $(this).attr("src");
                }).get();

                $("#bannerImage").remove(); // Remove old banner input

                if (remainingImages.length > 0) {
                    let newBanner = remainingImages[0]; // Get first available image

                    if (newBanner.startsWith("http")) {
                        // If it's an existing image, store it as text input
                        $(".frm_row").append(`<input type="hidden" id="bannerImage" name="bannerImage" value="${newBanner}">`);
                    } else {
                        // If it's a new uploaded image, store it as a file input
                        let file = uploadedFiles.find(item => item.file && item.file.name);
                        if (file) {
                            let fileInput = $('<input>', {
                                type: 'file',
                                name: 'bannerImage',
                                id: 'bannerImage',
                                class: 'inpt',
                                style: 'display: none;'
                            })[0];

                            let dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file.file);
                            fileInput.files = dataTransfer.files;

                            $(".frm_row").append(fileInput);
                        }
                    }
                }
            }


            // Convert Base64 Data URL to Blob
            function dataURItoBlob(dataURI) {
                let byteString = atob(dataURI.split(",")[1]);
                let mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

                let arrayBuffer = new ArrayBuffer(byteString.length);
                let uint8Array = new Uint8Array(arrayBuffer);

                for (let i = 0; i < byteString.length; i++) {
                    uint8Array[i] = byteString.charCodeAt(i);
                }

                return new Blob([uint8Array], { type: mimeString });
            }

        });
    </script>
    




    
@endsection