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
            <h2 class="order__active_total-header">
              {{ $title }}
            </h2>
          </div>
        </div>
      </div>

      @if($products)
        <div class="col-12">
          <div class="table-responsive-lg" style="padding: 0 20px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Size</th>
                  <th>Order Details</th>
                </tr>
              </thead>

              <tbody>
                @foreach($products as $product)
                  @php $orderProduct = $orderProducts[$product->shopify_id] @endphp
                  <tr>
                    <td class="center">
                      <div class="d-flex align-items-center">
                        {{ $serial++ }}
                      </div>
                    </td>
                    <td class="content">
                      <div class="d-flex align-items-center">
                        <img src="{{ $orderProduct['image']['src'] }}" class="img-fluid img-thumbnail">
                        <div class="content">
                          <h3>{{ $orderProduct['title'] }}</h3>
                        </div>
                      </div>
                    </td>
                    <td class="center">
                      <div class="d-flex align-items-center">
                        {{ $fmt->formatCurrency($orderProduct['variants'][0]['price'], 'INR') }}
                      </div>
                    </td>
                    <td class="center">
                      <div class="d-flex align-items-center">
                        {{ $product->size }}
                      </div>
                    </td>

                    <td class="center">
                      <div class="d-flex align-items-center">
                        <a href="{{ $order['order_status_url'] }}" target="_blank">Details</a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </div>
  </div>

  

@include('layouts.includes.admin.adminNavFooter')