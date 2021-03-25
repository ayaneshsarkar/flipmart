@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        @if(Session::get('success'))
          <div class="adminSession {{ (Session::get('success')) ? 'success' : '' }}">
            <div class="adminSession__inner">
              <p>{{ Session::get('success') }}</p>
              <p id="adminCross">x</p>
            </div>
          </div>
        @endif
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget widget-tile">
          <span class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
          <div class="data-info">
            <div class="desc">Orders</div>
            <div class="value">
              <span class="icon" style="color: #2196F3"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
              <span class="number">{{ 0 }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget widget-tile">
          <span class="icon">
            <svg class="bi bi-life-preserver" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
              <path d="M11.642 6.343L15 5v6l-3.358-1.343A3.99 3.99 0 0 0 12 8a3.99 3.99 0 0 0-.358-1.657zM9.657 4.358L11 1H5l1.343 3.358A3.985 3.985 0 0 1 8 4c.59 0 1.152.128 1.657.358zM4.358 6.343L1 5v6l3.358-1.343A3.985 3.985 0 0 1 4 8c0-.59.128-1.152.358-1.657zm1.985 5.299L5 15h6l-1.343-3.358A3.984 3.984 0 0 1 8 12a3.99 3.99 0 0 1-1.657-.358z"/>
            </svg>
          </span>
          <div class="data-info">
            <div class="desc">Products</div>
            <div class="value">
              <span class="icon" style="color: #2196F3"><i class="fa fa-chevron-right" aria-hidden="true"></i>
              </span>
              <span class="number">{{ $productCount }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget widget-tile">
          <span class="icon"><i class="fa fa-tasks" aria-hidden="true"></i></span>
          <div class="data-info">
            <div class="desc">Categories</div>
            <div class="value">
              <span class="icon">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
              </span>
              <span class="number">{{ $categoryCount }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 col-md-12">
        <div class="product_link product">
          <div class="product_link__inner">
            <p>
              <a href="{{ URL::to('/addproduct') }}">
                <span class="icon"><i class="fa fa-cart-plus"></i></span> Add Product
              </a>
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="product_link category">
          <div class="product_link__inner">
            <p>
              <a href="{{ URL::to('/addcategory') }}">
                <span class="icon"><i class="fa fa-plus-square"></i></span> Add Category
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')
      