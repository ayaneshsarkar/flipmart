@include('layouts.includes.admin.adminNavHeader')

@php
  $class = '';
  if(Session::get('success')) {
    $class = 'success';
  }

  if(Session::get('danger')) {
    $class = 'danger';
  }

@endphp

  <div class="item_wrap" id="mainItems">
    <div class="row">
      @if(Session::get('success'))
        <div class="col-12">
          <div class="order__session {{ $class }}" id="orderSession">
            <div class="order__session_content">{{ Session::get('success') }}</div>
            <div class="order__session_content cross" id="orderSessionCross">x</div>
          </div>
        </div>
      @endif

      @if(Session::get('danger'))
        <div class="col-12">
          <div class="order__session {{ $class }}" id="orderSession">
            <div class="order__session_content">{{ Session::get('danger') }}</div>
            <div class="order__session_content cross" id="orderSessionCross">x</div>
          </div>
        </div>
      @endif

      <div class="col-12">
        <div class="order__active">
          <div class="order__active_total">
            <h2 class="order__active_total-header">Active Orders &ndash; 
              <span>{{ count($count) }} (${{ $total }})</span>
            </h2>
          </div>
        </div>
      </div>

      <div class="col-12">

        @foreach ($items as $item)
            
          <div class="orderbox">
            <div class="orderbox__inner">
              <div class="orderbox__inner_item">
                <div class="orderbox__inner_item-title">
                  <h4 class="heading">Title</h4>
                  <p class="title">{{ $item->title }}</p>
                </div>
              </div>

              <div class="orderbox__inner_item">
                <div class="orderbox__inner_item-title">
                  <p class="heading">Price</p>
                  <h4 class="price">${{ $item->orderTotal }}</h4>
                </div>
              </div>

              <div class="orderbox__inner_item">
                <div class="orderbox__inner_item-title">
                  <p class="heading">Delivery Time 
                    <span class="m-l-3"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                  </p>
                  <h4 class="time">{{ $item->delivery_days }} day(s)</h4>
                </div>
              </div>
            </div>
          </div>

        @endforeach

      </div>
    </div>
  </div>

  

@include('layouts.includes.admin.adminNavFooter')