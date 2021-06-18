<div class="header-cart header-dropdown" id="cartDropdown">
  @if(session('loggedIn') == TRUE)
    <ul class="header-cart-wrapitem cartDropdownItem" id="cartResults">
      @if(count($cartResults['cartData']) === 0)
        <p>Nothing Here</p>
      @endif
      
      @if(!empty($cartResults))
        @foreach ($cartResults['shopifyData'] as $cartResult)
          @php 
            $productId = 
            DB::table('products')->where('shopify_id', $cartResult['id'])->first()->id;

            $cart = DB::table('carts')->where('product_id', $productId)->first();
					@endphp

          <li class="header-cart-item"  id="cart-{{ $cart->id }}">
            <a class="cartImage">
              <div class="header-cart-item-img" data-cart="{{ $cart->id }}">
                <img src="{{ $cartResult['image']['src'] }}" alt="{{ $cartResult['title'] }}">
              </div>
            </a>
      
            <div class="header-cart-item-txt">
              <a href="/shop/{{ $cartResult['id'] }}" class="header-cart-item-name">
                {{ $cartResult['title'] }}
              </a>
      
              <span class="header-cart-item-info">
                {{ $cart->quantity }} x {{ $cartResult['variants'][0]['price'] }}
              </span>
            </div>
          </li>
        @endforeach
      @endif
    </ul>
  @endif

    <div class="header-cart-total" id="cartTotal">
      Total: ${{ !empty($cartTotal) && $cartTotal > 0 ? $cartTotal : 0 }}
    </div>

    <div class="header-cart-buttons">
      <div class="header-cart-wrapbtn" style="width: 100% !important;">
        <!-- Button -->
        <a href="/cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
          View Cart
        </a>
      </div>

      {{-- <div class="header-cart-wrapbtn">
        <!-- Button -->
        <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
          Check Out
        </a>
      </div> --}}
    </div>
  {{-- @endif --}}
</div>