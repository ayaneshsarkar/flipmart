@include('layouts.includes.header')
<div class="wrapper mediaTab">
  <div class="top_navbar">
    <div class="adminLogo">
      <a href="{{ URL::to('/') }}">FlipMart</a>
    </div>

    <div class="top_menu">
      <div class="home_link">
        <a href="{{ URL::to('/') }}">
          <span class="icon"><i class="fa fa-home"></i></span>
          <span>Home</span>
        </a>
      </div>

      <div class="right_info">
        <div class="icon_wrap">
          <div class="icon">
            <i class="fa fa-user" aria-hidden="true"></i>
          </div>
        </div>

        <div class="icon_wrap" id="toggleMenu" style="display: none">
          <div class="icon">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="main_body">
    <div class="sidebar_menu">
      <div class="sidebar_menu__inner">
        <ul>
          <li>
            <a href="{{ URL::to('/admin') }}">
              <span class="icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
              <span class="list">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="{{ URL::to('/orders') }}" class="active">
              <span class="icon">
                <svg class="bi bi-life-preserver" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                  <path d="M11.642 6.343L15 5v6l-3.358-1.343A3.99 3.99 0 0 0 12 8a3.99 3.99 0 0 0-.358-1.657zM9.657 4.358L11 1H5l1.343 3.358A3.985 3.985 0 0 1 8 4c.59 0 1.152.128 1.657.358zM4.358 6.343L1 5v6l3.358-1.343A3.985 3.985 0 0 1 4 8c0-.59.128-1.152.358-1.657zm1.985 5.299L5 15h6l-1.343-3.358A3.984 3.984 0 0 1 8 12a3.99 3.99 0 0 1-1.657-.358z"/>
                </svg>
              </span>
              <span class="list">Orders</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-pie-chart" aria-hidden="true"></i>
              </span>
              <span class="list">Reports</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
              </span>
              <span class="list">View Products</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
              </span>
              <span class="list">Add Product</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-desktop" aria-hidden="true"></i>
              </span>
              <span class="list">Categories</span>
            </a>
          </li>

          {{-- <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-sliders" aria-hidden="true"></i>
              </span>
              <span class="list">Slides</span>
            </a>
          </li> --}}
        </ul>

        <div class="hamberger">
          <div class="hamberger_inner">
            <span class="arrow">
              <i class="fa fa-long-arrow-left toggledLeft" aria-hidden="true"></i>
              <i class="fa fa-long-arrow-right toggledRight" aria-hidden="true" style="display: none"></i>
            </span>
          </div>
        </div>

      </div>
    </div>

    <div class="container">
      <div class="dropdown_mobile">
        <div class="dropdown_mobile-wrap">
          <div class="item">
            <ul>
              
              <li>
                <a href="#">
                  <span class="icon m-r-5"><i class="fa fa-home"></i></span>
                  <span class="list">Home</span>
                </a>
              </li>

              <li>
                <a href="#">
                  <span class="icon m-r-5"><i class="fa fa-bell"></i></span>
                  <span class="list">Notifications</span>
                </a>
              </li>
            
            </ul>
          </div>
        </div>
      </div>