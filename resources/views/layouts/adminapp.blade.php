<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SOUTH CALCUTTA</title>
  <meta name="description" content="" />
  <meta name="author" content="admin" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/favicon.ico" alt="" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('css/aos.css')}}" />
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/jquery.fancybox.css')}}" />
  <link rel="stylesheet" href="{{asset('css/easy-responsive-tabs.css')}}" />
  <link rel="stylesheet" href="{{asset('css/swiper.css')}}" />
  <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
  <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>
  <main>
    <section class="total_parent_element dash1">
      @include('layouts.adminsidebar')
      <div class="right_parent_element">
        <div class="outr_parent_nav dashb">
          <div class="lft_p_nav">
            <div class="sidebar">
              <img src="{{asset('images/mnu_icn.png')}}" alt="menu_icon" />
            </div>
            <a href="javascript:void(0);">
              <div class="top_logo">
                <img src="{{asset('images/logo.png')}}" alt="mob_logo" />
              </div>
            </a>
            <h2>south calcutta<br/> sri jain swetamber terapanthi sabha</h2>
            <div class="all_r_btn use">
              <a href="javascript:void(0)">
                <span class="user_icn">
                  <i class="fa-regular fa-user"></i> </span></a>
            </div>
          </div>
          <div class="rgt_p_nav prfl">
            <div class="all_r_btn">
              <a href="javascript:void(0)">
                <span class="user_icn">
                  <i class="fa-regular fa-user"></i> </span></a>
              <a href="javascript:void(0)">
                <span class="mail_icn">
                  <i class="fa-regular fa-envelope"></i>
                </span>
              </a>
              <a href="javascript:void(0)">
                <span class="notifi_icn">
                  <i class="fa-regular fa-bell"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="outr-right-content jst_event">
          @yield('content')
        </div>
        <div class="mob_ftr">
          <div class="ftr_lnks">
            <div class="ftr_lnk">
              <a href="" class="nav-link">
                <div class="icon_box">
                  <!-- <img src="{{asset('images/s_i1.png')}}" alt="nav_icon1" /> -->
                   <span><i class="fa-solid fa-location-dot"></i></span>
                </div>
                <span class="icon_text"> My Area </span>
              </a>
              <a href="javascript:void(0);" class="nav-link">
                <div class="icon_box">
                  <!-- <img src="{{asset('images/ldr.png')}}" alt="nav_icon1" /> -->
                  <span><i class="fa-solid fa-square-poll-vertical"></i></span>
                </div>
                <span class="icon_text"> Points </span>
              </a>
              <a href="javascript:void(0);" class="nav-link">
                <div class="icon_box">
                  <!-- <img src="{{asset('images/ldr.png')}}" alt="nav_icon1" /> -->
                  <span><i class="fa-solid fa-location-crosshairs"></i></span>
                </div>
                <span class="icon_text"> Home </span>
              </a>
              <a href="javascript:void(0);" class="nav-link">
                <div class="icon_box">
                  <!-- <img src="{{asset('images/s_i3.png')}}" alt="nav_icon1" /> -->
                  <span><i class="fa-regular fa-message"></i></span>
                </div>
                <span class="icon_text"> Chats </span>
              </a>
              <a href="javascript:void(0);" class="nav-link">
                <div class="icon_box">
                  <!-- <img src="{{asset('images/s_i4.png')}}" alt="nav_icon1" /> -->
                  <span><i class="fa-solid fa-phone"></i></span>
                </div>
                <span class="icon_text"> Contacts </span>
              </a>
            </div>
          </div>

          <div class="ftr_img_logo">
            <img src="{{asset('images/ftr_logo.png')}}" alt="ftr_logo" />
          </div>
        </div>
      </div>
      </div>
    </section>
  </main>

  @yield('customJs')

</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>


<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/font-awesome-all.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('js/easy-responsive-tabs.js') }}"></script>
<script src="{{ asset('js/swiper.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script>
  AOS.init();
</script>
<script src="{{ asset('js/custom.js') }}"></script>

</html>