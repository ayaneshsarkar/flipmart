<div class="header-cart header-dropdown" id="cartDropdown">

  @if(session('loggedIn') == TRUE)

    @foreach ($cartResults as $cartResult)
      <ul class="header-cart-wrapitem cartDropdownItem">
        <li class="header-cart-item">
          <div class="header-cart-item-img">
            <img src="images/item-cart-01.jpg" alt="IMG">
          </div>
    
          <div class="header-cart-item-txt">
            <a href="#" class="header-cart-item-name">
              {{ $cartResult->title }}
            </a>
    
            <span class="header-cart-item-info">
              {{ $cartResult->quantity }} x {{ $cartResult->cartPrice }}
            </span>
          </div>
        </li>
      </ul>
    @endforeach

  @else

    <p>Nothing Here</p>

  @endif

  {{-- <ul class="header-cart-wrapitem" id="cartDropdownItem">
    <li class="header-cart-item">
      <div class="header-cart-item-img">
        <img src="images/item-cart-01.jpg" alt="IMG">
      </div>

      <div class="header-cart-item-txt">
        <a href="#" class="header-cart-item-name">
          White Shirt With Pleat Detail Back
        </a>

        <span class="header-cart-item-info">
          1 x $19.00
        </span>
      </div>
    </li>
  </ul> --}}

  <div class="header-cart-total">
    Total: $75.00
  </div>

  <div class="header-cart-buttons">
    <div class="header-cart-wrapbtn">
      <!-- Button -->
      <a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
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
</div>