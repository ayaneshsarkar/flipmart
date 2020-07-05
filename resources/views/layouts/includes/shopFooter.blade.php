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
          <a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
        </div>
      </div>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Categories
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="#" class="s-text7">
            Men
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Women
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Dresses
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Sunglasses
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
          <a href="#" class="s-text7">
            Search
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            About Us
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Contact Us
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Returns
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
          <a href="#" class="s-text7">
            Track Order
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Returns
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Shipping
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            FAQs
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
      <h4 class="s-text12 p-b-30">
        Newsletter
      </h4>

      <form>
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
    <a href="#">
      <img class="h-size2" src="images/icons/paypal.png" alt="IMG-PAYPAL">
    </a>

    <a href="#">
      <img class="h-size2" src="images/icons/visa.png" alt="IMG-VISA">
    </a>

    <a href="#">
      <img class="h-size2" src="images/icons/mastercard.png" alt="IMG-MASTERCARD">
    </a>

    <a href="#">
      <img class="h-size2" src="images/icons/express.png" alt="IMG-EXPRESS">
    </a>

    <a href="#">
      <img class="h-size2" src="images/icons/discover.png" alt="IMG-DISCOVER">
    </a>

    <div class="t-center s-text8 p-t-20">
      Copyright © <?= date('Y'); ?> All rights reserved. | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
    </div>
  </div>
</footer>



<!-- Back to top -->
<div class="btn-back-to-top bg0-hov" id="myBtn">
  <span class="symbol-btn-back-to-top">
    <i class="fa fa-angle-double-up" aria-hidden="true"></i>
  </span>
</div>

<!-- Container Selection -->
<div id="dropDownSelect1"></div>
<div id="dropDownSelect2"></div>



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

  $(".selection-2").select2({
    minimumResultsForSearch: 20,
    dropdownParent: $('#dropDownSelect2')
  });
</script>
<!--===============================================================================================-->
<script type="text/javascript" src="vendor/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="vendor/slick/slick.min.js"></script>
<script type="text/javascript" src="js/slick-custom.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="vendor/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">

if(document.getElementById('successCart')) {
  $('.block2-btn-addcart').each(function(){
    var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
    $(this).on('click', function(){
      swal(nameProduct, "is added to cart !", "success");
    });
  });
}

if(document.getElementById('errorCart')) {
  $('.block2-btn-addcart').each(function(){
    var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
    $(this).on('click', function(){
      swal(nameProduct, "cannot add to cart, please Sign In!", "error");
    });
  });
}
  

$('.block2-btn-addwishlist').each(function(){
  var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
  $(this).on('click', function(){
    swal(nameProduct, "is added to wishlist !", "success");
  });
});
</script>

<!--===============================================================================================-->
<script type="text/javascript" src="vendor/noui/nouislider.min.js"></script>
<script type="text/javascript">
  /*[ No ui ]
    ===========================================================*/
    var filterBar = document.getElementById('filter-bar');

    noUiSlider.create(filterBar, {
        start: [ 10, 50 ],
        connect: true,
        range: {
            'min': 10,
            'max': 50
        }
    });

    var skipValues = [
    document.getElementById('value-lower'),
    document.getElementById('value-upper')
    ];

    //document.getElementById('value-lower').innerHTML = <?= $minRange; ?>
    //document.getElementById('value-upper').innerHTML = <?= $maxRange; ?>

    filterBar.noUiSlider.on('update', function( values, handle ) {
        skipValues[handle].innerHTML = Math.round(values[handle]) ;
        document.getElementById('minPrice').value = skipValues[0].innerHTML;
        document.getElementById('maxPrice').value = skipValues[1].innerHTML;
    });

</script>
<!--===============================================================================================-->

<script>
  document.getElementById('value-lower').innerHTML = `<?= $minRange; ?>`;
  document.getElementById('value-upper').innerHTML = `<?= $maxRange; ?>`;

  let sortResult = document.getElementById('sortResult');
  const sortForm = document.getElementById('sortForm');

  let sortSelection = document.querySelector('.selection-2');

  let selectText = document.querySelector('.select2-selection__rendered');

  if(document.querySelector('.highSort')) {
    sortSelection.value = 'Price: high to low';

    selectText.textContent = sortSelection.value;
  }

  if(document.querySelector('.lowSort')) {
    sortSelection.value = 'Price: low to high';

    selectText.textContent = sortSelection.value;
  }
  
  function sortSelectFunction() {
    if(sortSelection.value === 'Default Sorting') {
      sortResult.value = 'default';
      sortForm.submit();
    }
    if(sortSelection.value === 'Price: low to high') {
      sortResult.value = 'low';
      sortForm.submit();
    }
    if(sortSelection.value === 'Price: high to low') {
      sortResult.value = 'high';
      sortForm.submit();
    }
  }

  const accountDropdown = document.querySelector('.header-account-dropdown');

  if(accountDropdown) {
    $('#account').click(function() {
      $('.header-account-dropdown').toggleClass('show-header-account-dropdown');
    });
  }
  
</script>

<script src="{{ asset('js/ajax.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>