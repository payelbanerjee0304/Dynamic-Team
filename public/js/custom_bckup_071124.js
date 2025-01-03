// const fileInput = document.getElementById("fileInput");
// const imagePreview = document.getElementById("imagePreview");
// const dropArea = document.getElementById("dropArea");
// const icon = document.getElementById("icon");

// icon.addEventListener("click", () => {
//   fileInput.click();
// });

// dropArea.addEventListener("click", () => {
//   fileInput.click();
// });

// dropArea.addEventListener("dragover", (e) => {
//   e.preventDefault();
//   dropArea.classList.add("hover");
// });

// dropArea.addEventListener("dragleave", () => {
//   dropArea.classList.remove("hover");
// });

// dropArea.addEventListener("drop", (e) => {
//   e.preventDefault();
//   dropArea.classList.remove("hover");
//   const file = e.dataTransfer.files[0];
//   handleFile(file);
// });

// fileInput.addEventListener("change", (event) => {
//   const file = event.target.files[0];
//   handleFile(file);
// });

// function handleFile(file) {
//   if (file && file.type.startsWith("image/")) {
//     const reader = new FileReader();
//     reader.onload = function (e) {
//       imagePreview.src = e.target.result;
//       imagePreview.style.display = "block";
//     };
//     reader.readAsDataURL(file);
//   } else {
//     alert("Please upload a valid image file.");
//   }
// }

// // multi step form moumi 30.9.24

// document.addEventListener("DOMContentLoaded", function () {
//   const steps = document.querySelectorAll(".frm_cnt");
//   const nextBtn = document.getElementById("nextBtn");
//   const backBtn = document.getElementById("backBtn");
//   const resetBtn = document.getElementById("resetBtn");
//   const submitBtn = document.getElementById("submitBtn");
//   const lineSpans = document.querySelectorAll(".line_span");
//   let currentStep = 0;

//   showStep(currentStep);

//   function showStep(stepIndex) {
//     steps.forEach((step, index) => {
//       step.classList.toggle("active", index === stepIndex);
//     });
//     updateButtons();
//   }

//   function validateCurrentStep() {
//     const currentInputs =
//       steps[currentStep].querySelectorAll("input, textarea");
//     for (const input of currentInputs) {
//       if (!input.value) {
//         return false;
//       }
//     }
//     return true;
//   }

//   function updateButtons() {
//     backBtn.style.display = currentStep === 0 ? "none" : "inline-block";
//     backBtn.style.color = currentStep === 0 ? "#fff" : "#000";
//     nextBtn.style.display =
//       currentStep === steps.length - 1 ? "none" : "inline-block";
//     resetBtn.style.display =
//       currentStep === steps.length - 1 ? "inline-block" : "none";
//     submitBtn.style.display =
//       currentStep === steps.length - 1 ? "inline-block" : "none";
//   }

//   nextBtn.addEventListener("click", () => {
//     // if (validateCurrentStep()) {
//     if (lineSpans[currentStep]) {
//       lineSpans[currentStep].style.backgroundColor = "red";
//     }

//     if (currentStep < steps.length - 1) {
//       currentStep++;
//       showStep(currentStep);
//     }
//     // }
//   });

//   backBtn.addEventListener("click", () => {
//     if (currentStep > 0) {
//       if (lineSpans[currentStep - 1]) {
//         lineSpans[currentStep - 1].style.backgroundColor = "#fff";
//       }

//       currentStep--;
//       showStep(currentStep);
//     }
//   });
// });
