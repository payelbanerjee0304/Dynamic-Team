
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".sidebar");
    const leftBar = document.querySelector(".left_parent_element");
    const rightBar = document.querySelector(".right_parent_element");
    const closeButton = document.querySelector("#closeBtn"); // Ensure this ID matches the close button
  
    sidebar.addEventListener("click", (event) => {
        event.preventDefault();
        leftBar.classList.toggle("active");
  
        if (leftBar.classList.contains("active")) {
            leftBar.style.width = "150px";
            rightBar.style.width = "93%";
            rightBar.style.position = "fixed";
        } else {
            leftBar.style.width = ""; 
            rightBar.style.width = "85%";
            rightBar.style.position = "relative";
        }
    });
  
    closeButton.addEventListener("click", () => {
        leftBar.classList.remove("active"); 
        leftBar.style.width = "";
        rightBar.style.width = "100%";
        rightBar.style.position = "relative";
    });
  });

// ====================================================================
//ayon js 07.11.24
// $(document).ready(function () {
//     $(".drv_tbl_icns.dropdown .dropdown-toggle").click(function () {
//     $(this).toggleClass("svg-active");
//     });
// });
$(document).ready(function () {
    $(document).on("click", ".drv_tbl_icns.dropdown .dropdown-toggle", function () {
        $(this).toggleClass("svg-active");
    });
});

// ======================================================================
// moumi attachment file

const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');
const icon = document.getElementById('icon');

// Store the default image source in a variable
const defaultImageSrc = imagePreview.src;

icon.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        // Allowed image types
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        // Check if the file type is valid
        if (allowedTypes.includes(file.type)) {
            // If valid, read and display the image
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result; // Update the preview
            };
            reader.readAsDataURL(file); // Read the file
        } else {
            // Invalid file type
            alert('Only image files (JPG, PNG, GIF, WEBP) are allowed.');
            fileInput.value = ''; // Clear the input
            imagePreview.src = defaultImageSrc; // Reset to the default image
        }
    } else {
        // If no file is selected, reset to the default image
        imagePreview.src = defaultImageSrc;
    }
});


// multi step form moumi 06.11.24
// document.addEventListener('DOMContentLoaded', function () {
//     const steps = document.querySelectorAll('.frm_cnt');
//     const numDivs = document.querySelectorAll('.num_div'); // Step number indicators
//     const num = document.querySelectorAll('.num');
//     const lineSpans = document.querySelectorAll('.line_span'); // Progress bar spans
//     const nextBtn = document.getElementById('nextBtn');
//     const backBtn = document.getElementById('backBtn');
//     const resetBtn = document.getElementById('resetBtn');
//     const submitBtn = document.getElementById('submitBtn');
//     let currentStep = 0;

//     showStep(currentStep);

//     function showStep(stepIndex) {
//         steps.forEach((step, index) => {
//             step.classList.toggle('active', index === stepIndex);
//         });
//         updateNumDivs();
//         updateLineSpans();
//         updateButtons();
//     }

//     function validateCurrentStep() {
//         const currentInputs = steps[currentStep].querySelectorAll('input, textarea');
//         for (const input of currentInputs) {
//             if (!input.value) {
//                 return false;
//             }
//         }
//         return true;
//     }

//     function updateNumDivs() {
//         numDivs.forEach((numDiv, index) => {
//             if (index <= currentStep) {
//                 numDiv.style.backgroundColor = 'red';
//                 numDiv.style.color = 'white'; // Ensure text color is white when active
//             } else {
//                 numDiv.style.backgroundColor = '';
//                 numDiv.style.color = '';
//             }
//         });
//         num.forEach((num, i) => {
//             if (i <= currentStep) {
//                 num.style.color = 'white';
//             } else {
//                 num.style.color = 'black';
//             }
//         })
//     }

//     function updateLineSpans() {
//         lineSpans.forEach((span, index) => {
//             // Set the background color of line spans to red for completed steps, white for incomplete steps
//             if (index < currentStep) {
//                 span.style.backgroundColor = 'red'; // Red for completed steps
//             } else {
//                 span.style.backgroundColor = 'white'; // White for incomplete steps
//             }
//         });
//     }

//     function updateButtons() {
//         backBtn.style.display = (currentStep === 0) ? 'none' : 'inline-block';
//         backBtn.style.color = (currentStep === 0) ? '#fff' : '#000';
//         nextBtn.style.display = (currentStep === steps.length - 1) ? 'none' : 'inline-block';
//         resetBtn.style.display = (currentStep === steps.length - 1) ? 'inline-block' : 'none';
//         submitBtn.style.display = (currentStep === steps.length - 1) ? 'inline-block' : 'none';
//     }

    

//     nextBtn.addEventListener('click', () => {
//         // if (validateCurrentStep()) {
//         //     if (currentStep < steps.length - 1) {
//         //         currentStep++;
//         //         showStep(currentStep);
//         //     }
//         // }
//         var stepNumber = currentStep;

//         if (lineSpans[currentStep]) {
//             lineSpans[currentStep].style.backgroundColor = "red";
//         }

//         if (currentStep < steps.length - 1) {
//             currentStep++;
//             showStep(currentStep);
//         }
//         if (validateCurrentStep()) {
//         }
//     });

//     backBtn.addEventListener('click', () => {
//         if (currentStep > 0) {
//             currentStep--;
//             showStep(currentStep);
//         }
//     });
// });

//=====================================================================
