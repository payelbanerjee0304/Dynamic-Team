<div class="left_parent_element">
    <div class="total_upper_left">
      <span class="left_span_close" id="closeBtn">
        <i class="fa-solid fa-xmark"></i>
      </span>
      <div class="nav_area">
        <div class="outr_dashboard_nav">
          <div class="parent_nav_menu">
            <ul class="pnmul">
              <li class="nav-item">
                <a href="{{route('chiefadmin.dashboard')}}" class="nav-link">
                  <div class="icon_box">
                    <img src="{{asset('images/menu1.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text"> Home </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a
                  href="javascript:void(0);"
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="eventDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <div class="icon_box">
                    <img src="{{asset('images/menu2.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text">News</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="eventDropdown">
                  <li><a class="dropdown-item" href="javascript:void(0);">Create News</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">All News</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ route('chiefadmin.dashboard') }}" class="nav-link">
                  <div class="icon_box">
                    <img src="{{asset('images/menu3.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text"> Organizers </span>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a
                  href="javascript:void(0);"
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="eventDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <div class="icon_box">
                    <img src="{{asset('images/menu4.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text">Event </span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="eventDropdown">
                  <li><a class="dropdown-item" href="#">Action 1</a></li>
                  <li><a class="dropdown-item" href="#">Action 2</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link">
                  <div class="icon_box">
                    <img src="{{asset('images/menu5.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text"> Birthday </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a
                  href="javascript:void(0);"
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="eventDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <div class="icon_box">
                    <img src="{{asset('images/menu6.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text">Settings</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="eventDropdown">
                  <li><a class="dropdown-item" href="#"> Action 1 </a></li>
                  <li><a class="dropdown-item" href="#">Action 2</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{route('chiefadmin.logout')}}" class="nav-link">
                  <div class="icon_box">
                    <img src="{{asset('images/menu4.png')}}" alt="nav_icon1" />
                  </div>
                  <span class="icon_text"> Logout </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="logo_area">
        <div class="nav_btm_logo">
          <!-- <a href="#"
            ><img src="{{asset('images/sidebar_logo.png')}}" alt="logo"
          /></a> -->
        </div>
      </div>
    </div>
</div>