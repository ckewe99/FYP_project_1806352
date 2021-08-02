  <!-- Topnav -->
  <div class="header bg-primary mb-6">
      <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
          <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Navbar links -->
                  <ul class="navbar-nav align-items-center ml-md-auto">
                      <li class="nav-item d-xl-none">
                          <!-- Sidenav toggler -->
                          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                              data-target="#sidenav-main">
                              <div class="sidenav-toggler-inner">
                                  <i class="sidenav-toggler-line"></i>
                                  <i class="sidenav-toggler-line"></i>
                                  <i class="sidenav-toggler-line"></i>
                              </div>
                          </div>
                      </li>
                  </ul>
                  <ul class="navbar-nav align-items-center  mr-auto mr-md-0 ">
                      <li class="nav-item dropdown">
                          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              <div class="media align-items-center">
                                  <span style="font-size: 20px">
                                    <i class="fas fa-users-cog"></i>
                                  </span>
                                  <span class="mb-0 ml-2 text-sm  font-weight-bold">
                                        {{ Auth::user()->name }}</span>
                              </div>
                          </a>
                          <div class="dropdown-menu  dropdown-menu-right ">
                              <div class="dropdown-header noti-title">
                                  <h6 class="text-overflow m-0">Welcome!</h6>
                              </div>
                              <a href="{{ route('profile') }}" class="dropdown-item">
                                  <i class="ni ni-single-02"></i>
                                  <span>My profile</span>
                              </a>
                              <div class="dropdown-divider"></div>
                              <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                  <i class="ni ni-user-run"></i>
                                  {{ __('Logout') }}
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
  </div>
