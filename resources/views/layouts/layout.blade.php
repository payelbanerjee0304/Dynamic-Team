<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SOUTH CALCUTTA </title>
    <meta name="description" content="" />
    <meta name="author" content="admin" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0" />
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" alt="" />
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Wittgenstein:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/aos.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/jquery.fancybox.css')}}" />
    <link rel="stylesheet" href="{{asset('css/easy-responsive-tabs.css')}}" />
    <link rel="stylesheet" href="{{asset('css/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />
</head>

<body>
    <main>
        @yield('content')
       
    </main>
    <!--Header End-->

    <!-- Back to top button -->

    <a href="javascript:void(0);" id="backToTop">
        <i class="fa fa-solid fa-arrow-up"></i>
    </a>

    <!-- Back to top button -->

    <!-- Jquery  -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Font Awesome JS -->
    <script src="{{asset('js/font-awesome-all.min.js')}}"></script>
    <!-- Fancy Box -->
    <script src="{{asset('js/jquery.fancybox.pack.js')}}"></script>
    <!-- Easy Responsive Tab -->
    <script src="{{asset('js/easy-responsive-tabs.js')}}"></script>
    <!-- Swiper -->
    <script src="{{asset('js/swiper.js')}}"></script>
    <!-- AOS JS -->
    <script src="{{asset('js/aos.js')}}"></script>
    <script>
        AOS.init();
    </script>
    <!-- Custom JS -->
    <script src="{{asset('js/custom.js')}}"></script>

    <script>
        const fileInput = document.getElementById("fileInput");
        const imagePreview = document.getElementById("imagePreview");
        const dropArea = document.getElementById("dropArea");
        const icon = document.getElementById("icon");

        icon.addEventListener("click", () => {
            fileInput.click();
        });

        dropArea.addEventListener("click", () => {
            fileInput.click();
        });

        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("hover");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("hover");
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("hover");
            const file = e.dataTransfer.files[0];
            handleFile(file);
        });

        fileInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                alert("Please upload a valid image file.");
            }
        }

        // multi step form moumi 30.9.24

        // document.addEventListener("DOMContentLoaded", function() {
        //     const steps = document.querySelectorAll(".frm_cnt");
        //     const nextBtn = document.getElementById("nextBtn");
        //     const backBtn = document.getElementById("backBtn");
        //     const resetBtn = document.getElementById("resetBtn");
        //     const submitBtn = document.getElementById("submitBtn");
        //     const lineSpans = document.querySelectorAll(".line_span");
        //     let currentStep = 0;

        //     showStep(currentStep);

        //     function showStep(stepIndex) {
        //         steps.forEach((step, index) => {
        //             step.classList.toggle("active", index === stepIndex);
        //         });
        //         updateButtons();
        //     }

        //     function validateCurrentStep() {
        //         const currentInputs =
        //             steps[currentStep].querySelectorAll("input, textarea");
        //         for (const input of currentInputs) {
        //             if (!input.value) {
        //                 return false;
        //             }
        //         }
        //         return true;
        //     }

        //     function updateButtons() {
        //         backBtn.style.display = currentStep === 0 ? "none" : "inline-block";
        //         backBtn.style.color = currentStep === 0 ? "#fff" : "#000";
        //         nextBtn.style.display =
        //             currentStep === steps.length - 1 ? "none" : "inline-block";
        //         resetBtn.style.display =
        //             currentStep === steps.length - 1 ? "inline-block" : "none";
        //         submitBtn.style.display =
        //             currentStep === steps.length - 1 ? "inline-block" : "none";
        //     }

        //     nextBtn.addEventListener("click", () => {
        //         var stepNumber = currentStep;

        //         if (lineSpans[currentStep]) {
        //             lineSpans[currentStep].style.backgroundColor = "red";
        //         }

        //         if (currentStep < steps.length - 1) {
        //             currentStep++;
        //             showStep(currentStep);
        //         }
        //         // if (validateCurrentStep()) {
        //         // } else {
        //         //     checkValidations(stepNumber);
        //         // }
        //     });

        //     backBtn.addEventListener("click", () => {
        //         if (currentStep > 0) {
        //             if (lineSpans[currentStep - 1]) {
        //                 lineSpans[currentStep - 1].style.backgroundColor = "#fff";
        //             }

        //             currentStep--;
        //             showStep(currentStep);
        //         }
        //     });


        //     function checkValidations(stepNumber) {
        //         // console.log(stepNumber);

        //         if (stepNumber == 0) {
        //             const membershipNumber = document.getElementById("memberNumber").val();
        //         }


        //     }
        // });


        document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.frm_cnt'); 
        const numDivs = document.querySelectorAll('.num_div'); // Step number indicators
        const num = document.querySelectorAll('.num'); 
        const lineSpans = document.querySelectorAll('.line_span'); // Progress bar spans
        const nextBtn = document.getElementById('nextBtn'); 
        const backBtn = document.getElementById('backBtn'); 
        const resetBtn = document.getElementById('resetBtn'); 
        const submitBtn = document.getElementById('submitBtn'); 
        let currentStep = 0;

        showStep(currentStep);

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
            updateNumDivs();
            updateLineSpans();
            updateButtons(); 
        }

        function validateCurrentStep() {
            const currentInputs = steps[currentStep].querySelectorAll('input, textarea');
            for (const input of currentInputs) {
                if (!input.value) {
                    return false; 
                }
            }
            return true;
        }

        function updateNumDivs() {
            numDivs.forEach((numDiv, index) => {
                if (index <= currentStep) {
                    numDiv.style.backgroundColor = 'red';
                    numDiv.style.color = 'white'; // Ensure text color is white when active
                } else {
                    numDiv.style.backgroundColor = '';
                    numDiv.style.color = '';
                }
            });
            num.forEach((num,i) => {
                if (i <= currentStep) {
                    num.style.color = 'white';
                } else {
                    num.style.color = 'black';
                }
            })
        }

        function updateLineSpans() {
            lineSpans.forEach((span, index) => {
                // Set the background color of line spans to red for completed steps, white for incomplete steps
                if (index < currentStep) {
                    span.style.backgroundColor = 'red'; // Red for completed steps
                } else {
                    span.style.backgroundColor = 'white'; // White for incomplete steps
                }
            });
        }

        function updateButtons() {
            backBtn.style.display = (currentStep === 0) ? 'none' : 'inline-block'; 
            backBtn.style.color = (currentStep === 0) ? '#fff' : '#000'; 
            nextBtn.style.display = (currentStep === steps.length - 1) ? 'none' : 'inline-block'; 
            resetBtn.style.display = (currentStep === steps.length - 1) ? 'inline-block' : 'none';
            submitBtn.style.display = (currentStep === steps.length - 1) ? 'inline-block' : 'none';
        }

        

        nextBtn.addEventListener('click', () => {
            // if (validateCurrentStep()) {
            //     if (currentStep < steps.length - 1) {
            //         currentStep++;
            //         showStep(currentStep);
            //     }
            // }
            var stepNumber = currentStep;

            if (lineSpans[currentStep]) {
                lineSpans[currentStep].style.backgroundColor = "red";
            }

            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
            if (validateCurrentStep()) {
            } 
        });

        backBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
    </script>
</body>

</html>