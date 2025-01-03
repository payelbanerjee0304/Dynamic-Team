let inputImage = document.getElementById("inputImage");
let image = document.getElementById("image");
let croppedImage = document.getElementById("croppedImage");

let cropButton = document.getElementById("cropButton");

var cropper;
var fileName;

inputImage.addEventListener("change", (e) => {
  let files = e.target.files;
  fileName = files[0].name; // Get the file name
  let reader = new FileReader();
  reader.onload = function (event) {
    image.src = event.target.result;
    $("#cropModal").modal("show");
  };
  reader.readAsDataURL(files[0]);
});

$(".hide_modal").click(function () {
  $("#cropModal").modal("hide");
  inputImage.value = "";
});

$("#cropModal")
  .on("shown.bs.modal", () => {
    cropper = new Cropper(image, {
      //   aspectRatio: 0.5,
      viewMode: 1,
    });
  })
  .on("hidden.bs.modal", () => {
    cropper.destroy();
    cropper = null;
  });

cropButton.addEventListener("click", () => {
  canvas = cropper.getCroppedCanvas();
  base64Image = canvas.toDataURL(); // Get the base64 code of the cropped image
  base64String = base64Image.split(",")[1];

  croppedImage.src = base64Image;

  croppedImage.style.display = "block";
  $("#logoFileName").val(fileName);
  $("#logoFileData").val(base64String);
  $("#cropModal").modal("hide");

  // console.log("File Name:", fileName);
  // console.log("Base64 Image:", base64Image);
});
