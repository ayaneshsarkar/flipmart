<!-- Footer -->
<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
  <div class="flex-w p-b-90">
    <div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
      <h4 class="s-text12 p-b-30">
        GET IN TOUCH
      </h4>

      <div>
        <p class="s-text7 w-size27">
          Any questions? Let us know in South Sreepur Boral, Kolkata - 700154 OR Call us on (+91) 9836994302
        </p>

        <div class="flex-m p-t-30">
          <a href="https://facebook.com" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
          <a href="https://instagram.com" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
          <a href="https://in.pintrest.com" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
          <a href="https://snapchat.com" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
          <a href="https://youtube.com" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
        </div>
      </div>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Categories
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="/shop?category=men" class="s-text7">
            Men
          </a>
        </li>

        <li class="p-b-9">
          <a href="/shop?category=women" class="s-text7">
            Women
          </a>
        </li>

        <li class="p-b-9">
          <a href="/shop?category=kids" class="s-text7">
            Kids
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Links
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="/about" class="s-text7">
            About Us
          </a>
        </li>

        <li class="p-b-9">
          <a href="/contact" class="s-text7">
            Contact Us
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Help
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="/contact" class="s-text7">
            Contact Us
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
      <h4 class="s-text12 p-b-30">
        Newsletter
      </h4>

      <form id="newsletterForm">
        <div class="effect1 w-size9">
          <input class="s-text7 bg6 w-full p-b-5" type="text" name="email" placeholder="email@example.com">
          <span class="effect1-line"></span>
        </div>

        <div class="w-size2 p-t-20">
          <!-- Button -->
          <button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
            Subscribe
          </button>
        </div>

      </form>
    </div>
  </div>

  <div class="t-center p-l-15 p-r-15">
    <a>
      <img class="h-size2" src="{{ asset('images/icons/paypal.png') }}" alt="IMG-PAYPAL">
    </a>

    <a>
      <img class="h-size2" src="{{ asset('images/icons/visa.png') }}" alt="IMG-VISA">
    </a>

    <a>
      <img class="h-size2" src="{{ asset('images/icons/mastercard.png') }}" alt="IMG-MASTERCARD">
    </a>

    <a>
      <img class="h-size2" src="{{ asset('images/icons/express.png') }}" alt="IMG-EXPRESS">
    </a>

    <a>
      <img class="h-size2" src="{{ asset('images/icons/discover.png') }}" alt="IMG-DISCOVER">
    </a>

    <div class="t-center s-text8 p-t-20">
      Copyright © <?= date('Y') ?> All rights reserved.
    </div>
  </div>
</footer>



	<!-- Back to top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<!-- Container Selection1 -->
	<div id="dropDownSelect1"></div>



<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script type="text/javascript" src="{{ asset('vendor/slick/slick.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="{{ asset('vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="{{ asset('vendor/lightbox2/js/lightbox.min.js') }}"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript">
		// $('.block2-btn-addcart').each(function(){
		// 	var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
		// 	$(this).on('click', function(){
		// 		swal(nameProduct, "is added to cart !", "success");
		// 	});
		// });

		// $('.block2-btn-addwishlist').each(function(){
		// 	var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
		// 	$(this).on('click', function(){
		// 		swal(nameProduct, "is added to wishlist !", "success");
		// 	});
		// });
	</script>

<!--===============================================================================================-->
	{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
	<script>
		var account = document.getElementById('account');
		var accountDropdown = document.querySelector('.header-account-dropdown');

		if(account && accountDropdown) {
			account.addEventListener('click', function() {
				accountDropdown.classList.toggle('show-header-account-dropdown');
			});
		}
		

		var logoutText = document.getElementById('logoutText');
		var logoutForm = document.getElementById('logoutForm');

		if(logoutText && logoutForm) {
			logoutText.addEventListener('click', function() {
				logoutForm.submit();
			});
		}
	</script>

	<script src="{{ asset('js/ajax.js') }}"></script>
	<script src="{{ asset('js/modal.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>