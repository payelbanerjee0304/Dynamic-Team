<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Chief Admin</title>
  <meta name="description" content="" />
  <meta name="author" content="admin" />
  <meta name="viewport" content="width=device-width; initial-scale=1.0" />
  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" alt="" />
  <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('css/aos.css')}}" />
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/jquery.fancybox.css')}}" />
  <link rel="stylesheet" href="{{asset('css/easy-responsive-tabs.css')}}" />
  <link rel="stylesheet" href="{{asset('css/swiper.css')}}" />
  <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
  <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <style>
    /* Hide the up/down arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Hide the side scrollbar */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
</head>

<body>
  <main class="jst_login sc_login">
    <header class="login_logo lft_p_nav">
    <div class="top_hdr">
                    {{-- <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" />
                    </div>
                    <div class="top_h">
                        <h2>south calcutta<br/> sri jain swetamber terapanthi sabha</h2>
                    </div> --}}
                </div>
    </header>
    <section class="login-part">
      <div class="d_brd_tp">
        <h3>Login to System</h3>
      </div>
      <div class="login-form lgn_frm_two ">
        <form id="loginForm">
          @csrf
          <!-- @if(session('message'))
            <div class="alert alert-info">{{session('message')}}</div>
            @endif -->
          <div class="form_control">
            <input type="number" placeholder="Enter your Mobile No." id="mobile" name="mobile" />
            <div id="mobile_error" class="error"></div>
            @error('mobile')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <!-- <div class="form_control">
              <input type="password" id="password" name="password" placeholder="Password"
              />
              <div id="password_error" class="error"></div>
              @error('password')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div> -->
          <div id="sendOtp" class="sbmt_btn text-center">
            <input type="submit" name="submit" value="Send OTP" class="mainsb_btn" />
          </div>
          {{-- <div id="forgot">
            <a href="{{route('forget.password')}}">Forgot Password</a>
          </div>  --}}
          <div class="d_brd_ttl" id="otpDiv" style="display: none">
            <div class="d_brd_tp" id="enphone">
              <p>Enter the verification code we sent via Mobile</p>
            </div>
            <div class="tp_dgt_prt">
              <h6 id="vcodetext">Type your 6 digit security code</h6>
              <div class="verification-code" id="otp-form">
                <div class="verification-code--inputs">
                  <input type="number" maxlength="1" id="field1" class="form-input" />
                  <input type="number" maxlength="1" id="field2" class="form-input" />
                  <input type="number" maxlength="1" id="field3" class="form-input" />
                  <input type="number" maxlength="1" id="field4" class="form-input" />
                  <input type="number" maxlength="1" id="field5" class="form-input" />
                  <input type="number" maxlength="1" id="field6" class="form-input" />

                  <!-- {{-- <input type="number" name="otp" id="otp" class="form-control"> --}} -->
                </div>
                <input type="hidden" id="verificationCode" />
              </div>
            </div>

            <div id="finalSubmit" class="sbmt_btn text-center">
              <input type="submit" class="mainsb_btn login_btn cmn_btn" value="Submit" name="finalSubmitbutton" id="finalSubmitbutton" />
              <input type="submit" name="resend" id="resend" class="mainsb_btn login_btn" value="Resend OTP" style="display: none" />
            </div>
            <div class="d_brd_tp">
              <p>Time left: <span id="timer"></span></p>
            </div>
          </div>
        </form>
      </div>
    </section>
    <footer class="lgin_ftr">
      {{-- <p>© 2024 <a href="javascript:void(0);">SOUTH CALCUTTA</a></p> --}}
    </footer>
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

  <!-- Code Verification -->
  <script>
    var verificationCode = [];
    $(".verification-code input[type=text]").keyup(function(e) {
      // Get Input for Hidden Field
      $(".verification-code input[type=text]").each(function(i) {
        verificationCode[i] = $(".verification-code input[type=text]")[
          i
        ].value;
        $("#verificationCode").val(Number(verificationCode.join("")));
        //console.log( $('#verificationCode').val() );
      });

      //console.log(event.key, event.which);

      if ($(this).val() > 0) {
        if (
          event.key == 1 ||
          event.key == 2 ||
          event.key == 3 ||
          event.key == 4 ||
          event.key == 5 ||
          event.key == 6 ||
          event.key == 7 ||
          event.key == 8 ||
          event.key == 9 ||
          event.key == 0
        ) {
          $(this).next().focus();
        }
      } else {
        if (event.key == "Backspace") {
          $(this).prev().focus();
        }
      }
    }); // keyup

    // $('.verification-code input').on("paste", function (event, pastedValue) {
    //   console.log(event)
    //   $('#txt').val($content)
    //   console.log($content)
    // });

    $editor.on("paste, keydown", function() {
      //jsfiddle.net/5bNx4/#run
      http: var $self = $(this);
      setTimeout(function() {
        var $content = $self.html();
        $clipboard.val($content);
      }, 100);
    });
  </script>

  <!-- Custom JS -->
  <script src="js/custom.js"></script>

  <script>
    const form = document.querySelector("#otp-form");
    const inputs = document.querySelectorAll(".form-input");
    const verifyBtn = document.querySelector(".login_btn");
    const isAllInputFilled = () => {
      return Array.from(inputs).every((item) => item.value);
    };
    const getOtpText = () => {
      let text = "";
      inputs.forEach((input) => {
        text += input.value;
      });
      return text;
    };
    const verifyOTP = () => {
      if (isAllInputFilled()) {
        const text = getOtpText();
        //alert(`Your OTP is "${text}". OTP is correct`);
      }
    };
    const toggleFilledClass = (field) => {
      if (field.value) {
        field.classList.add("filled");
      } else {
        field.classList.remove("filled");
      }
    };
    form.addEventListener("input", (e) => {
      const target = e.target;
      const value = target.value;
      //console.log({ target, value });
      toggleFilledClass(target);
      if (target.nextElementSibling) {
        target.nextElementSibling.focus();
      }
      verifyOTP();
    });
    inputs.forEach((input, currentIndex) => {
      // fill check
      toggleFilledClass(input);
      // paste event
      input.addEventListener("paste", (e) => {
        e.preventDefault();
        const text = e.clipboardData.getData("text");
        //console.log(text);
        inputs.forEach((item, index) => {
          if (index >= currentIndex && text[index - currentIndex]) {
            item.focus();
            item.value = text[index - currentIndex] || "";
            toggleFilledClass(item);
            verifyOTP();
          }
        });
      });
      // backspace event
      input.addEventListener("keydown", (e) => {
        if (e.keyCode === 8) {
          e.preventDefault();
          input.value = "";
          // console.log(input.value);
          toggleFilledClass(input);
          if (input.previousElementSibling) {
            input.previousElementSibling.focus();
          }
        } else {
          if (input.value && input.nextElementSibling) {
            input.nextElementSibling.focus();
          }
        }
      });
    });
    verifyBtn.addEventListener("click", () => {
      verifyOTP();
    });
  </script>

  <!-- payelJs -->

  <script>
    $(document).ready(function() {
      $(".text-danger").remove();

      $('input[name="mobile"]').on('input', function() {
        $(this).siblings('.text-danger').text('').css('color', 'black');
      });

      $('#mobile').on('input', function() {
        var mobile = $(this).val();
        var mobileRegex = /^\d{10}$/;
        if (mobile === '') {
          $('#mobile_error').text('Mobile number is required').css('color', 'red');
        } else if (!mobileRegex.test(mobile)) {
          $('#mobile_error').text('Mobile number must be 10 digits').css('color', 'red');
        } else {
          $('#mobile_error').text('');
        }
      });

      //stop after 10th digit
      $('#mobile').on('keydown', function(event) {
        if (this.value.length >= 10 && event.key !== 'Backspace' && event.key !== 'Delete') {
          event.preventDefault();
        }
        // Prevent the input of the decimal point
        if (event.key === '.' || event.key === 'Decimal') {
          event.preventDefault();
        }
      });

      function showErrorSwal(message) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: message,
          customClass: {
            popup: "my-swal-popup",
            icon: "my-swal-icon",
            title: "my-swal-title",
            content: "my-swal-content",
            text: "my-swal-content",
            confirmButton: "my-swal-confirm-button",
          },
        });
      }
      //all for resend
      var timerDisplay = $('#timer');
      var countdownDuration = 120; // 2 minutes in seconds
      var resend = $('#resend');

      // Function to start the countdown
      function startCountdown() {
        // Logic to update and display the countdown timer
        var secondsLeft = countdownDuration;

        // Update the timer display
        function updateTimerDisplay() {
          var minutes = Math.floor(secondsLeft / 60);
          var seconds = secondsLeft % 60;

          // Format the time as MM:SS
          var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') +
            seconds;

          // Set the text content of the #timer span
          $('#timer').text(formattedTime);
        }

        // Update the timer display initially
        updateTimerDisplay();

        // Countdown interval
        var countdownInterval = setInterval(function() {
          secondsLeft--;

          // Update the timer display
          updateTimerDisplay();

          // Check if countdown is complete
          if (secondsLeft <= 0) {
            // Clear the countdown interval
            clearInterval(countdownInterval);
            //Show/hide elements based on countdown completion
            $('#resend, #otpvia2').show();
            $('#finalSubmitbutton, #field1, #field2, #field3, #field4, #field5, #field6, #vcodetext, #enphone')
              .hide();
            $('#field1, #field2, #field3, #field4, #field5, #field6').val('');
          }
        }, 1000);
      }

      function handleFormSubmission() {
        let mobile = $('#mobile').val();

        // Perform your Ajax request here
        $.ajax({
          type: "POST",
          url: "{{ route('chiefadmin.save') }}",
          data: {
            _token: "{{ csrf_token() }}",
            mobile: mobile,
          },
          success: function(response) {
            if (response.status == "error") {
              showErrorSwal(response.message);
              $("#email").prop("enabled", true);
              $("#password").prop("enabled", true);
              $("#otpDiv").hide();
              $("#sendOtp").show();
              $("#finalSubmit").hide();
              // console.log(response);
            } else {
              $("#email").prop("disabled", true);
              $("#password").prop("disabled", true);
              $("#otpDiv").show();
              $("#forgot").hide();
              $("#sendOtp").hide();
              $("#finalSubmit").show();

              otp = response[0]["otp"];
              // console.log(otp);
              Swal.fire({
                icon: "success",
                title: "Your One-time password",
                text: otp,
                customClass: {
                  popup: "my-swal-popup",
                  icon: "my-swal-icon",
                  title: "my-swal-title",
                  content: "my-swal-content",
                  text: "my-swal-content",
                  confirmButton: "my-swal-confirm-button",
                },
              });
            }
            startCountdown();
          },
          error: function(error) {
            // Clear existing error messages
            $(".text-danger").remove();

            // Display validation errors below each input field

            $.each(error.responseJSON.errors, function(field, messages) {
              var inputField = $("#" + field);
              inputField.after(
                '<span class="text-danger lgn-msg">' + messages[0] + "</span>"
              );
            });
          },
        });
      }
      $("#loginForm").submit(function(e) {
        e.preventDefault();
        let isValid = true;

        $('.text-danger').text('');

        if ($('#mobile').val() === '') {
          $('#mobile_error').text('mobile field is required').css('color', 'red');
          isValid = false;
        }
        //   let email = $('#email').val();
        //  let password = $('#password').val();
        if (isValid) {
          handleFormSubmission();
        }

      });

      // Handling click on the "Resend" button
      $('#resend').click(function() {
        $('#finalSubmitbutton, #field1, #field2, #field3, #field4, #field5, #field6, #vcodetext, #enphone')
          .show();
        $('#resend, #otpvia2').hide();
        // Calling the sendOTP function
        handleFormSubmission();
        // Starting the countdown again
        // startCountdown();
      });

      $(document).on("click", "#finalSubmitbutton", function(e) {
        e.preventDefault();
        // Getting values from input fields
        // let email = $("#email").val();
        // let password = $("#password").val();
        let mobile = $('#mobile').val();
        let otp = $("#otp").val();

        // Get values from each input field
        var field1 = $('#field1').val();
        var field2 = $('#field2').val();
        var field3 = $('#field3').val();
        var field4 = $('#field4').val();
        var field5 = $('#field5').val();
        var field6 = $('#field6').val();

        // Combining values into a single field
        var combinedValue = field1 + field2 + field3 + field4 + field5 + field6;
        $.ajax({
          type: "POST",
          url: '{{ route("chiefadmin.verifyAndLogin") }}',
          data: {
            _token: "{{ csrf_token() }}",
            mobile: mobile,
            otp: combinedValue,
          },
          success: function(response) {
            // console.log(response);
            // console.log(response.user[0].id);
            // var idNumber = response.user[0].id;
            // Redirect to the dashboard page with the phone number as a query parameter
            window.location.href = '{{ route("chiefadmin.dashboard") }}'; //
          },
          error: function(xhr, status, error) {
            var response = JSON.parse(xhr.responseText);
            if (xhr.status === 404 && response.status === "error") {
              showErrorSwal(response.message);
            } else {
              $.each(response.errors, function(field, message) {
                $("#" + field + "_error").text(message[0]);
              });
            }
          },
        });
      });
    });
  </script>
</body>

</html>