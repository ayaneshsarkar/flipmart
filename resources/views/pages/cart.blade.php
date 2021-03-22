@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
	@include('layouts.pages.modalSignUp')

<script>
	function cartPlus(el) {

		var quantity = parseInt(el.previousElementSibling.value) + 1;
		var cartId = el.parentElement.getElementsByTagName('input')[1].value;
		var cartTotal = el.parentElement.parentElement.nextElementSibling;

		axios.post('/cartupdate', {
			quantity: quantity,
			cartId: cartId
		}).then(function(res) {

			console.log(res.data);

			cartTotal.textContent = `$${res.data.singleTotal}.00`;
			document.getElementById('singleCartTotal').textContent = `$${res.data.total}.00`;

		}).catch(function(err) {
			console.log(err);
		});

		

	}

	function cartMinus(el) {
		var quantity = parseInt(el.nextElementSibling.value) - 1;
		
		if((parseInt(el.nextElementSibling.value) - 1) == 0) {
			var quantity = 1;
		}

		var cartId = el.parentElement.getElementsByTagName('input')[1].value;
		var cartTotal = el.parentElement.parentElement.nextElementSibling;

		axios.post('/cartupdate', {
			quantity: quantity,
			cartId: cartId
		}).then(function(res) {

			console.log(res.data);

			cartTotal.textContent = `$${res.data.singleTotal}.00`;
			document.getElementById('singleCartTotal').textContent = `$${res.data.total}.00`;

		}).catch(function(err) {
			console.log(err);
		});

	}
</script>
	
	@php
		function defineImagePath($name, $userId, $image) {
      return "/storage/myimages/$name$userId/$image";
		}

	@endphp

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/heading-pages-01.jpg);">
		<h2 class="l-text2 t-center">
			Cart
		</h2>
	</section>

	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<div id="noProduct" style="display: none; font-size: 20px">Currently we have nothing for you.</div>
			<!-- Cart item -->
			<div class="container-table-cart pos-relative" id="cartTable">
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						<tr class="table-head">
							<th class="column-1"></th>
							<th class="column-2">Product</th>
							<th class="column-3">Price</th>
							<th class="column-4 p-l-70">Quantity</th>
							<th class="column-5">Total</th>
						</tr>

						{{-- Cart Items --}}

							@if(session('loggedIn') == TRUE)
							
								@foreach ($cartResults as $cart)

									<tr class="table-row">
										<td class="column-1">
											<div class="cart-img-product b-rad-4 o-f-hidden singleCartImage">
												<img src="{{ asset(defineImagePath($cart->name, $cart->userId, $cart->main_image)) }}" 
												alt="{{ $cart->title }}">
												<input type="hidden" class="singleCartId" name="singleCartId" value={{ $cart->cartId }} readonly="readonly">
											</div>
										</td>
										<td class="column-2">{{ $cart->title }}</td>
										<td class="column-3">${{ $cart->price }}.00</td>
										<td class="column-4">
											<div class="flex-w bo5 of-hidden w-size17">
												<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2" 
												onclick="cartMinus(this);">
													<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
												</button>

												<input class="size8 m-text18 t-center num-product singleCartQuantity" type="number" name="num-product" 
												value="{{ $cart->quantity }}">
			
												<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2" onclick="cartPlus(this);">
													<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
												</button>

												<input type="hidden" class="singleCartId" name="singleCartId" value={{ $cart->cartId }} readonly="readonly">
											</div>
										</td>
										<td class="column-5">${{ $cart->total }}.00</td>
									</tr>

								@endforeach

							@else

								<p>Nothing Here</p>

							@endif							
						
						{{-- <tr class="table-row">
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden">
									<img src="images/item-05.jpg" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2">Mug Adventure</td>
							<td class="column-3">$16.00</td>
							<td class="column-4">
								<div class="flex-w bo5 of-hidden w-size17">
									<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
									</button>

									<input class="size8 m-text18 t-center num-product" type="number" name="num-product2" value="1">

									<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
									</button>
								</div>
							</td>
							<td class="column-5">$16.00</td>
						</tr> --}}
					</table>
				</div>
			</div>

			{{-- Update Button --}}
			<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm" id="updateButton" style="justify-content: flex-end">
				{{-- <div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<!-- Button -->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
							Apply coupon
						</button>
					</div>
				</div> --}}

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="updateCart">
						Update Cart
					</button>
				</div>
			</div>

			<!-- Total -->
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
				<h5 class="m-text20 p-b-24">
					Cart Totals
				</h5>

				<!--  -->
				{{-- <div class="flex-w flex-sb-m p-b-12" style="border-bottom: 1px dashed #d9d9d9;">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						${{ $cartTotal }}.00
					</span>
				</div> --}}

				<!--  -->
				{{-- <div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Shipping:
					</span>

					<div class="w-size20 w-full-sm">
						<p class="s-text8 p-b-23">
							There are no shipping methods available. Please double check your address, or contact us if you need any help.
						</p>

						<span class="s-text19">
							Calculate Shipping
						</span>

						<div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-t-8 m-b-12">
							<select class="selection-2" name="country">
								<option>Select a country...</option>
								<option>US</option>
								<option>UK</option>
								<option>Japan</option>
							</select>
						</div>

						<div class="size13 bo4 m-b-12">
						<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="state" placeholder="State /  country">
						</div>

						<div class="size13 bo4 m-b-22">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="postcode" placeholder="Postcode / Zip">
						</div>

						<div class="size14 trans-0-4 m-b-10">
							<!-- Button -->
							<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
								Update Totals
							</button>
						</div>
					</div>
				</div> --}}

				<!-- Total -->
				<div class="flex-w flex-sb-m p-t-26 p-b-30" style="border-top: 1px dashed #d9d9d9;">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm" id="singleCartTotal">
						${{ $cartTotal ?? 0 }}.00
					</span>
				</div>

				<div class="size15 trans-0-4">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="checkoutButton">
						Proceed to Checkout
					</button>

					{{ Form::open(['action' => 'OrdersController@createOrder', 'method' => 'POST', 'id' => "order"]) }}
						<input type="hidden" name="order">
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</section>


  @include('layouts.includes.cartFooter')