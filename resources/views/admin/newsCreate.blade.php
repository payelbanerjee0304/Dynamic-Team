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
    .daterangepicker .calendar-table th,
        .daterangepicker .calendar-table td {
            line-height: 6px !important;
        }

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
          <div class="multi_top_dir">Create News</div>
            <form action="javascript:void(0)" method="POST" id="dynamic-form">
                    @csrf

                    <div class="frm_cnt" id="frm_cnt1">
                        {{-- <h1>Membership Informations</h1> --}}
                        <div class="frm_row">
                            <label>Title</label>
                            <input type="text" name="title" id="title" placeholder="Enter title" />
                            <small class="error-message" id="title_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Content</label>
                            <textarea class="mt_dscrb_bx" id="content" name="content" placeholder="Enter content" style="width: 100%;"></textarea>
                            <small class="error-message" id="content_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Banner Image</label>
                            <input type="file" class="inpt" id="inputImage" name="inputImage" placeholder="" accept="image/*">
                            <img id="croppedImage" class="croppedImage" alt="Cropped Image" style="display: none;max-width: 100%; margin-top: 20px;" src="">

                            <input id="logoFile" name="logoFile" type="file" hidden />
                            <input id="logoFileName" name="logoFileName" class="logoFileName" type="hidden" />
                            <input id="logoFileData" name="logoFileData" class="logoFileData" type="hidden" />
                            <small class="error-message" id="inputImage_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Other Uploaded Images</label>
                            <input type="file" class="inpt" id="inputImages1" name="inputImages1" multiple accept="image/*">
                            <div id="croppedImagesContainer" style="margin-top: 20px;"></div>
                            <input id="logoFileData1" name="logoFileData1" class="logoFileData" type="hidden" />
                            <small class="error-message" id="inputImages1_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>Start Date</label>
                            <input type="date" class="inpt dates" id="startDate" name="startDate" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="startDate_error"></small>
                        </div>
                        <div class="frm_row">
                            <label>End Date</label>
                            <input type="date" class="inpt dates" id="endDate" name="endDate" placeholder="" style="cursor: pointer;" />
                            <small class="error-message" id="endDate_error"></small>
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

<!-- Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                <button type="button" class="close hide_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary hide_modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="cropButton">Crop</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cropModal1" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel1">Crop Image</h5>
                <button type="button" class="close hide_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imageToCrop1" alt="Image to crop">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary hide_modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="cropButton1">Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('customJs')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script src="{{ asset('js/news/cropImageEventCreation.js') }}"></script>
    {{-- <script src="{{ asset('js/event/ckeditor.js') }}"></script> --}}

    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {

            var today = new Date();
            var year = today.getFullYear();
            var month = (today.getMonth() + 1).toString().padStart(2, '0');
            var day = today.getDate().toString().padStart(2, '0');
            var minDate = year + '-' + month + '-' + day;
            var dateInputIds = ['startDate', 'endDate'];


            dateInputIds.forEach(function(id) {
                document.getElementById(id).setAttribute('min', minDate);
                document.getElementById(id).setAttribute('value', minDate);
            });

        });
    </script>

    <script>
        let inputImages1 = document.getElementById("inputImages1");
        let imageToCrop1 = document.getElementById("imageToCrop1");
        let croppedImagesContainer = document.getElementById("croppedImagesContainer");

        let cropper1;
        let currentFileName1;
        let currentImageSrc1;
        let croppedImagesData1 = [];

        inputImages1.addEventListener("change", (e) => {
            let files1 = e.target.files;

            // Limit to 5 images
            if (files1.length + croppedImagesContainer.children.length > 5) {
                alert("You can only upload a maximum of 5 images.");
                inputImages.value = ""; // Clear the input
                return; // Stop the process
            }

            if (files1.length > 0) {
                for (let file of files1) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        currentImageSrc1 = event.target.result; // Store the current image source
                        currentFileName1 = file.name; // Get the file name
                        imageToCrop1.src = currentImageSrc1; // Set image to crop
                        $("#cropModal1").modal("show"); // Show modal
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $(".hide_modal").click(function() {
            $("#cropModal1").modal("hide");
            inputImages1.value = ""; // Reset the input after closing the modal
        });

        $("#cropModal1").on("shown.bs.modal", () => {
            cropper1 = new Cropper(imageToCrop1, {
                aspectRatio: 472 / 272, // Fixed aspect ratio
                viewMode: 1,
                autoCropArea: 1, // Fill the crop box to the canvas
            });
        }).on("hidden.bs.modal", () => {
            cropper1.destroy();
            cropper1 = null;
        });

        document.getElementById("cropButton1").addEventListener("click", () => {
            const canvas = cropper1.getCroppedCanvas({
                width: 472, // Set fixed width for the cropped image
                height: 272, // Set fixed height for the cropped image
            });
            const base64Image = canvas.toDataURL(); // Get the base64 code of the cropped image
            const base64String = base64Image.split(",")[1];

            // Create a new div to hold the image and delete button
            const imageContainer = document.createElement("div");
            imageContainer.style.display = "flex"; // Use flex to align items
            imageContainer.style.alignItems = "center"; // Center align items
            imageContainer.style.margin = "5px"; // Set margin

            // Create a new image element for the cropped image preview
            let croppedImageElement = document.createElement("img");
            croppedImageElement.src = base64Image;
            croppedImageElement.classList.add("croppedImage"); // Add class for styling
            croppedImageElement.style.maxWidth = "100px"; // Set desired width
            croppedImageElement.alt = `Cropped Image - ${currentFileName1}`; // Set alt text

            // Create a delete button (cross icon)
            let deleteButton = document.createElement("button");
            deleteButton.innerHTML = "&#10005;"; // Cross symbol
            deleteButton.style.background = "transparent";
            deleteButton.style.border = "none";
            deleteButton.style.cursor = "pointer";
            deleteButton.style.marginLeft = "10px"; // Space between image and button
            deleteButton.title = "Delete Image"; // Tooltip for button

            // Append the image and delete button to the container
            imageContainer.appendChild(croppedImageElement);
            imageContainer.appendChild(deleteButton);
            croppedImagesContainer.appendChild(imageContainer); // Append the container to the main container

            // Store the base64 data
            croppedImagesData1.push({
                name: currentFileName1,
                data: base64String
            });

            $("#logoFileData1").val(JSON.stringify(croppedImagesData1)); // Store all base64 data
            $("#cropModal1").modal("hide");

            // Add click event to the delete button
            deleteButton.addEventListener("click", () => {
                // Remove the image from the DOM
                imageContainer.remove();

                // Find the index of the image in the croppedImagesData1 array
                const index = croppedImagesData1.findIndex(img => img.name === currentFileName1);

                // Remove the image from the croppedImagesData1 array if it exists
                if (index !== -1) {
                    croppedImagesData1.splice(index, 1);
                }

                // Update the hidden input with the modified array
                $("#logoFileData1").val(JSON.stringify(croppedImagesData1));
            });
        });
    </script>

    <script>
        let editorInstance;

        ClassicEditor.create(document.querySelector("#content"), {
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

        $(document).on("input", "input, textarea", function() {
            // validateForm();
        });

        const validateForm = () => {
            const checkAllFields = [
                hasNewsTitle(),
                hasNewsContent(),
                hasNewsImage(),
                hasStartDate(),
                hasEndDate()
            ];
            return checkAllFields.every((value) => value === true);
        };

        function hasNewsTitle() {
            const newsTitle = $("#title").val();

            if (!newsTitle) {
                $("#title_error").html("Enter news title");
                return false;
            } else {
                $("#title_error").html("");
                return true;
            }
        }

        function hasNewsContent() {
            const newsContent = editorInstance.getData().trim(); // Get content from CKEditor

            if (!newsContent) {
                $("#content_error").html("Enter news content");
                return false;
            } else {
                $("#content_error").html("");
                return true;
            }
        }
        // function hasNewsContent() {
        //     const newsContent = $("#content").val();

        //     if (!newsContent) {
        //         $("#content_error").html("Enter news content");
        //         return false;
        //     } else {
        //         $("#content_error").html("");
        //         return true;
        //     }
        // }

        function hasNewsImage() {
            const logoFileName = $("#logoFileName").val();

            if (!logoFileName) {
                $("#inputImage_error").html("Upload news image");
                return false;
            } else {
                $("#inputImage_error").html("");
                return true;
            }
        }

        function hasStartDate() {
            const startDate = $("#startDate").val();

            if (!startDate) {
                $("#startDate_error").html("Select start Date");
                return false;
            } else {
                $("#startDate_error").html("");
                return true;
            }
        }

        function hasEndDate() {
            const endDate = $("#endDate").val();

            if (!endDate) {
                $("#endDate_error").html("Select end Date");
                return false;
            } else {
                $("#endDate_error").html("");
                return true;
            }
        }

        $(document).on("click", "#submitBtn", function() {
            const formValidated = validateForm();

            // if (formValidated) {
                const newsTitle = $("#title").val();
                console.log(newsTitle);
                // const newsContent = $("#content").val();
                const newsContent = editorInstance.getData();
                const startDate = convertDateFormat($("#startDate").val());
                const endDate = convertDateFormat($("#endDate").val());

                const logoFileName = $("#logoFileName").val();
                const logoFileData = $("#logoFileData").val();

                const croppedImagesData = $("#logoFileData1").val(); // Assuming you store it in a hidden input

                var csrfToken = $('meta[name="csrf-token"]').attr("content");

                $.ajax({
                    url: "{{ route('admin.insertNews') }}",
                    type: "POST",
                    data: {
                        newsTitle,
                        newsContent,
                        startDate,
                        endDate,
                        logoFileName,
                        logoFileData,
                        croppedImagesData
                    },
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    success: function(response) {

                        console.log(response)
                        if (response.success == true) {
                            Swal.fire({
                                title: "Success!",
                                text: "News created successfully.",
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('admin.allNews') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Try Again!",
                                text: "There was a problem creating the news.",
                                icon: "error",
                                confirmButtonText: "OK",
                            });
                        }
                    },
                });
            // }
        });

        const convertDateFormat = (dateString) => {
            let dateParts = dateString.split("-");
            let formattedDate = Number(dateParts.join(""));
            return formattedDate;
        };
    </script>
@endsection