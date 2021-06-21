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
              {{ $user == 'admin' ? 'All' : 'Your' }} Orders &ndash; 
              <span>{{ $count }} (₹{{ floor($total) }})</span>
            </h2>
          </div>
        </div>
      </div>

      @if($items)
        <div class="col-12">
          <div class="table-responsive" style="padding: 0 20px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Invoice</th>
                  <th>Sub Total</th>
                  <th>Status</th>
                  <th></th>
                  @if($user ==='admin')
                    <th></th>
                    <th></th>
                  @endif
                </tr>
              </thead>

              <tbody>
                @foreach($items as $item)
                  @php 
                    $deliveryStatus = DB::table('orders')
                      ->where('shopify_order_id', $item['id'])
                      ->first()->status;
                  @endphp

                  <tr>
                    <td>
                      <a href="/order/?id={{ $item['id'] }}" target="_blank">
                        {{ $item['name'] }}
                      </a>
                    </td>
                    <td>
                      <a href="/download-invoice/{{ $item['id'] }}" target="_blank">
                        Invoice
                      </a>
                    </td>
                    <td>{{ $fmt->formatCurrency($item['current_subtotal_price'], 'INR') }}</td>
                    <td>
                      @if($deliveryStatus === 'delivered')
                        {{ 'Delivered' }}
                      @elseif($deliveryStatus === 'cancelled')
                        {{ 'Order Cancelled' }}
                      @else
                        {{ 'On The Way' }}
                      @endif
                    </td>

                    <td>
                      @if($deliveryStatus === 'cancelled')
                        CANCELLED
                      @elseif($deliveryStatus === 'open')
                        <a href="/cancel-order/{{ $item['id'] }}" class="alertswal">
                          Cancel Order
                        </a>
                      @endif
                    </td>

                    @if($user ==='admin')
                      <td>
                        @if($deliveryStatus === 'open')
                          <a href="/close-order/{{ $item['id'] }}" class="alertswal">Close</a>
                        @elseif($deliveryStatus === 'delivered')
                          <a href="/open-order/{{ $item['id'] }}" class="alertswal">Reopen</a>
                        @endif
                      </td>
                      <td>
                        <a href="/delete-order/{{ $item['id'] }}" class="alertswal">Delete</a>
                      </td>
                    @endif
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