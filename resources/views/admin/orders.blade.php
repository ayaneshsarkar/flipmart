@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="order__active">
          <div class="order__active_total">
            <h2 class="order__active_total-header">Active Orders &ndash; <span>3 ($300)</span></h2>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="orderbox">
          <div class="orderbox__inner">
            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <h4 class="heading">Title</h4>
                <p class="title">Adidas Shoes</p>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Price</p>
                <h4 class="price">$70</h4>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Delivery Time 
                  <span class="m-l-3"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                </p>
                <h4 class="time">5 days</h4>
              </div>
            </div>
          </div>
        </div>
        
        <div class="orderbox">
          <div class="orderbox__inner">
            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <h4 class="heading">Title</h4>
                <p class="title">Bata Shoes</p>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Price</p>
                <h4 class="price">$130</h4>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Delivery Time 
                  <span class="m-l-3"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                </p>
                <h4 class="time">12 days</h4>
              </div>
            </div>
          </div>
        </div>

        <div class="orderbox">
          <div class="orderbox__inner">
            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <h4 class="heading">Title</h4>
                <p class="title">Nike Shoes</p>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Price</p>
                <h4 class="price">$100</h4>
              </div>
            </div>

            <div class="orderbox__inner_item">
              <div class="orderbox__inner_item-title">
                <p class="heading">Delivery Time 
                  <span class="m-l-3"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                </p>
                <h4 class="time">10 days</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')