<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SOUTH CALCUTTA</title>
    <meta name="description" content="" />
    <meta name="author" content="admin" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0" />
    <link rel="shortcut icon" href="images/favicon.ico" alt="" />
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Wittgenstein:ital,wght@0,400..900;1,400..900&display=swap"
      rel="stylesheet"
    />
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
      <section class="total_parent_element">
        @include('layout.usersidebar')
        <div class="right_parent_element">
          <div class="outr_parent_nav">
            <div class="lft_p_nav">
              <div class="sidebar">
                <img src="{{asset('images/mnu_icn.png')}}" alt="menu_icon" />
              </div>
              <div class="top_hdr">
                <div class="logo">
                  <img src="{{asset('images/logo.png')}}" />
                </div>
                <div class="top_h">
                  <h2>
                    south calcutta<br />
                    sri jain swetamber terapanthi sabha
                  </h2>
                </div>
              </div>
              <div class="all_r_btn use">
                <a href="javascript:void(0)">
                  <span class="user_icn">
                    <i class="fa-regular fa-user"></i> </span
                ></a>
              </div>
            </div>
            <div class="rgt_p_nav">
              <!-- <div class="search_bar">
                <form action="">
                  <input
                    type="search"
                    placeholder="Search"
                    class="search_holder"
                  />
                  <input type="button" class="search-btn" />
                  <div class="icon">
                    <img src="./images/search_icn.png" alt="search_icn" />
                  </div>
                </form>
              </div> -->
              <div class="all_r_btn">
                <a href="javascript:void(0)">
                  <span class="user_icn">
                    <i class="fa-regular fa-user"></i> </span
                ></a>
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
          <div class="outr-right-content">
            @yield('content')
            
          </div>
          
        </div>
      </section>
    </main>
    @yield('customJs')
    <!-- <main>
     
    </main> -->

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
  </body>
</html>
