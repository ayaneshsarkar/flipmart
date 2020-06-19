@include('layouts.includes.header')

<div class="wrapper mediaTab">
  <div class="top_navbar">
    <div class="adminLogo">
      <a href="#">FlipMart</a>
    </div>

    <div class="top_menu">
      <div class="home_link">
        <a href="#">
          <span class="icon"><i class="fa fa-home"></i></span>
          <span>Home</span>
        </a>
      </div>

      <div class="right_info">
        <div class="icon_wrap">
          <div class="icon">
            <i class="fa fa-bell" aria-hidden="true"></i>
          </div>
        </div>

        <div class="icon_wrap">
          <div class="icon">
            <i class="fa fa-cog" aria-hidden="true"></i>
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
            <a href="#" class="active">
              <span class="icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
              <span class="list">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-first-order" aria-hidden="true"></i>
              </span>
              <span class="list">Orders</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
              </span>
              <span class="list">Reports</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
              </span>
              <span class="list">View Products</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
              </span>
              <span class="list">Add Product</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>
              </span>
              <span class="list">Categories</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <i class="fa fa-sliders" aria-hidden="true"></i>
              </span>
              <span class="list">Slides</span>
            </a>
          </li>
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
      <div class="item_wrap">
        <div class="item">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi nam ipsum voluptas doloribus expedita. Ab distinctio saepe laudantium sunt, ratione assumenda cumque? Cumque fugit similique beatae error praesentium illo sunt voluptatibus rem quaerat facere sit quae ipsa repellendus adipisci corrupti porro sapiente dolor, neque officia hic provident autem aliquam. Ad!
        </div>

        <div class="item">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi nam ipsum voluptas doloribus expedita. Ab distinctio saepe laudantium sunt, ratione assumenda cumque? Cumque fugit similique beatae error praesentium illo sunt voluptatibus rem quaerat facere sit quae ipsa repellendus adipisci corrupti porro sapiente dolor, neque officia hic provident autem aliquam. Ad!
        </div>

        <div class="item">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi nam ipsum voluptas doloribus expedita. Ab distinctio saepe laudantium sunt, ratione assumenda cumque? Cumque fugit similique beatae error praesentium illo sunt voluptatibus rem quaerat facere sit quae ipsa repellendus adipisci corrupti porro sapiente dolor, neque officia hic provident autem aliquam. Ad!
        </div>
      </div>
    </div>

  </div>
</div>


@include('layouts.includes.jsFooter')