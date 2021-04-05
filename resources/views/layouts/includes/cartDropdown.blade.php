<div class="header-cart header-dropdown" id="cartDropdown">
  @if(session('loggedIn') == TRUE)
    <ul class="header-cart-wrapitem cartDropdownItem" id="cartResults">
      @if(!empty($cartResults))
        @foreach ($cartResults as $cartResult)
          <li class="header-cart-item">
            <a href="#" class="cartImage">
              <div class="header-cart-item-img">
                <img src="{{ asset("storage/myimages/$cartResult->name$cartResult->userId/$cartResult->main_image") }}" alt="{{ $cartResult->title }}">
                <input type="hidden" name="cartId" id="cartId" value="{{ $cartResult->cartId }}">
              </div>
            </a>
      
            <div class="header-cart-item-txt">
              <a href="#" class="header-cart-item-name">
                {{ $cartResult->title }}
              </a>
      
              <span class="header-cart-item-info">
                {{ $cartResult->quantity }} x {{ $cartResult->cartPrice }}
              </span>
            </div>
          </li>
        @endforeach
      @else
        <p>Nothing Here</p>
      @endif
    </ul>
  @endif

  {{-- @if((!empty($cartTotal)) && $cartTotal > 0) --}}
    <div class="header-cart-total" id="cartTotal">
      Total: ${{ ((!empty($cartTotal)) && $cartTotal > 0) ? $cartTotal : 0 }}
    </div>

    <div class="header-cart-buttons">
      <div class="header-cart-wrapbtn">
        <!-- Button -->
        <a href="/cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
          View Cart
        </a>
      </div>

      <div class="header-cart-wrapbtn">
        <!-- Button -->
        <a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
          Check Out
        </a>
      </div>
    </div>
  {{-- @endif --}}
</div>