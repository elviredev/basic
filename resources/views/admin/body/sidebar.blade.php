<div class="app-sidebar-menu">
  <div class="h-100" data-simplebar>

    <!--- Sidemenu -->
    <div id="sidebar-menu">

      <div class="logo-box">
        <a href="{{ route('home') }}" class="logo logo-light">
          <span class="logo-sm">
            <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="24">
          </span>
        </a>
        <a href="{{ route('home') }}" class="logo logo-dark">
          <span class="logo-sm">
            <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="24">
          </span>
        </a>
      </div>

      <ul id="side-menu">

        <li class="menu-title">Menu</li>

        <li>
          <a href="{{ route('dashboard') }}" class="tp-link">
            <i data-feather="home"></i>
            <span> Dashboard </span>
          </a>
        </li>

        <li class="menu-title">Pages</li>

        <li>
          <a href="#sidebarReview" data-bs-toggle="collapse">
            <i data-feather="user"></i>
            <span> Review Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarReview">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('all.reviews') }}" class="tp-link">All Reviews</a>
              </li>
              <li>
                <a href="{{ route('add.review') }}" class="tp-link">Add Review</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarHero" data-bs-toggle="collapse">
            <i data-feather="alert-octagon"></i>
            <span> Hero Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarHero">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('get.hero') }}" class="tp-link">Get Hero</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarFeatures" data-bs-toggle="collapse">
            <i data-feather="aperture"></i>
            <span> Features Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarFeatures">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('all.features') }}" class="tp-link">All Features</a>
              </li>
              <li>
                <a href="{{ route('add.feature') }}" class="tp-link">Add Features</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarTool" data-bs-toggle="collapse">
            <i data-feather="cpu"></i>
            <span> Tool Quality Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarTool">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('get.tool') }}" class="tp-link">Get Tool</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarTabs" data-bs-toggle="collapse">
            <i data-feather="table"></i>
            <span> Tabs Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarTabs">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('get.tabs') }}" class="tp-link">Get Tabs</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarVideo" data-bs-toggle="collapse">
            <i data-feather="youtube"></i>
            <span> Video Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarVideo">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('get.video') }}" class="tp-link">Get Video</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarProcess" data-bs-toggle="collapse">
            <i data-feather="command"></i>
            <span> Process Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarProcess">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('all.process') }}" class="tp-link">All Process</a>
              </li>
              <li>
                <a href="{{ route('add.process') }}" class="tp-link">Add Process</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarFaqs" data-bs-toggle="collapse">
            <i data-feather="help-circle"></i>
            <span> Faq Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarFaqs">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('all.faqs') }}" class="tp-link">All Faqs</a>
              </li>
              <li>
                <a href="{{ route('add.faq') }}" class="tp-link">Add Faq</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarTeam" data-bs-toggle="collapse">
            <i data-feather="users"></i>
            <span> Team Setup </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarTeam">
            <ul class="nav-second-level">
              <li>
                <a href="{{ route('all.teams') }}" class="tp-link">All Teams</a>
              </li>
              <li>
                <a href="{{ route('add.team') }}" class="tp-link">Add Team</a>
              </li>
            </ul>
          </div>
        </li>

        <li class="menu-title mt-2">General</li>

        <li>
          <a href="#sidebarBaseui" data-bs-toggle="collapse">
            <i data-feather="package"></i>
            <span> Components </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarBaseui">
            <ul class="nav-second-level">
              <li>
                <a href="ui-accordions.html" class="tp-link">Accordions</a>
              </li>
              <li>
                <a href="ui-alerts.html" class="tp-link">Alerts</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="widgets.html" class="tp-link">
            <i data-feather="aperture"></i>
            <span> Widgets </span>
          </a>
        </li>

        <li>
          <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
            <i data-feather="cpu"></i>
            <span> Extended UI </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarAdvancedUI">
            <ul class="nav-second-level">
              <li>
                <a href="extended-carousel.html" class="tp-link">Carousel</a>
              </li>
              <li>
                <a href="extended-notifications.html" class="tp-link">Notifications</a>
              </li>
              <li>
                <a href="extended-offcanvas.html" class="tp-link">Offcanvas</a>
              </li>
              <li>
                <a href="extended-range-slider.html" class="tp-link">Range Slider</a>
              </li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarIcons" data-bs-toggle="collapse">
            <i data-feather="award"></i>
            <span> Icons </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarIcons">
            <ul class="nav-second-level">
              <li>
                <a href="icons-feather.html" class="tp-link">Feather Icons</a>
              </li>
              <li>
                <a href="icons-mdi.html" class="tp-link">Material Design Icons</a>
              </li>
            </ul>
          </div>
        </li>

      </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

  </div>
</div>
