  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
      <div class="scrollbar-inner">
          <!-- Brand -->
          <div class="sidenav-header d-flex align-items-center">
              <a class="navbar-brand" href="javascript:void(0)">
                  <img src="/assets/img/brand/school_logo.png" class="navbar-brand-img">
              </a>
              <div class="ml-auto">
                  <!-- Sidenav toggler -->
                  <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
                      data-target="#sidenav-main">
                      <div class="sidenav-toggler-inner">
                          <i class="sidenav-toggler-line"></i>
                          <i class="sidenav-toggler-line"></i>
                          <i class="sidenav-toggler-line"></i>
                      </div>
                  </div>
              </div>
          </div>
          <div class="navbar-inner">
              <!-- Collapse -->
              <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                  <!-- Nav items -->
                  <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link active" href="{{ route('home') }}">
                              <i class="ni ni-tv-2 text-primary"></i>
                              <span class="nav-link-text">Dashboard</span>
                          </a>
                      </li>
                      @if (roles() == 1)
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('users.index') }}">
                                  <i class="fas fa-user-friends"></i>
                                  <span class="nav-link-text">Users</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('classes.index') }}">
                                  <i class="fas fa-users-class"></i>
                                  <span class="nav-link-text">Class</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('chooseDateRange') }}">
                                  <i class="fas fa-book-open"></i>
                                  <span class="nav-link-text">Kitchen Menu</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('setting') }}">
                                  <i class="fas fa-cogs"></i>
                                  <span class="nav-link-text">Setting</span>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('date_range') }}">
                                  <i class="fas fa-calendar-day"></i>
                                  <span class="nav-link-text">Date Range</span>
                              </a>
                          </li>
                          {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('stalls.index') }}">
                                <i class="fal fa-hat-chef"></i>
                                <span class="nav-link-text">Stalls</span>
                            </a>
                        </li> --}}
                      @endif
                      @if (roles() == 4 || roles() == 3 || roles() == 1)
                          @if (Auth::user()->can_order)
                              @if (!Auth::user()->ordered)
                                  <li class="nav-item">
                                      <a class="nav-link" href="{{ route('order.index') }}">
                                          <i class="fas fa-user-shield"></i>
                                          <span class="nav-link-text">Order Booking</span>
                                      </a>
                                  </li>
                              @endif
                          @endif
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('orderHistory.selectDateateRange') }}">
                                  <i class="fas fa-file"></i>
                                  <span class="nav-link-text">Order History</span>
                              </a>
                          </li>
                      @endif
                  </ul>
                  <!-- Divider -->
                  <hr class="my-3">
              </div>
          </div>
      </div>
  </nav>
