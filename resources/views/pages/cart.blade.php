@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
	@include('layouts.pages.modalSignUp')

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" 
	style="background-image: linear-gradient(to right bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.6)), 
	url(images/cart.jpg);">
		<h2 class="l-text2 t-center">
			Cart
		</h2>
	</section>

	<!-- Cart -->
	@if($cartTotal === 0)
		<div id="noProduct" class="container" style="font-size: 20px; padding: 50px;">Currently we have nothing for you.</div>
	@else
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<!-- Cart item -->
			<div class="container-table-cart pos-relative" id="cartTable">
				<div class="wrap-table-shopping-cart bgwhite" id="cartTableBox">
					<table class="table-shopping-cart" id="cartTable">
						<thead>
							<tr class="table-head">
								<th class="column-1"></th>
								<th class="column-2">Product</th>
								<th class="column-3">Price</th>
								<th class="column-4 p-l-70">Quantity</th>
								<th class="column-5">Total</th>
							</tr>
						</thead>

						{{-- Cart Items --}}
						<tbody>
							@foreach ($carts['shopifyData'] as $product)
								@php 
									$productId = 
									DB::table('products')->where('shopify_id', $product['id'])->first()->id;

									$cart = DB::table('carts')->where('product_id', $productId)->first();
								@endphp

								<tr class="table-row" id="cart-{{ $cart->id }}">
									<td class="column-1">
										<div class="cart-img-product b-rad-4 o-f-hidden singleCartImage"
										data-cart="{{ $cart->id }}" >
											<img src="{{ $product['image']['src'] }}" alt="{{ $product['title'] }}">
										</div>
									</td>
									<td class="column-2">{{ $product['title'] }}</td>
									<td class="column-3">${{ $product['variants'][0]['price'] }}</td>
									<td class="column-4">
										<form class="singleCartQuantity">
											<div class="flex-w bo5 of-hidden w-size17">
												<button type="submit" class="btn-num-product-down color1 flex-c-m size7 bg8 eff2 cart-minus"
												data-product="{{ $cart->product_id }}" 
												data-shopify="{{ $product['id'] }}">
													<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
												</button>

												<input class="size8 m-text18 t-center num-product" type="number" name="quantity" 
												value="{{ $cart->quantity }}">
			
												<button type="submit" class="btn-num-product-up color1 flex-c-m size7 bg8 eff2 cart-plus"
												data-product="{{ $cart->product_id }}" 
												data-shopify="{{ $product['id'] }}">
													<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
												</button>
											</div>
										</form>
									</td>
									<td class="column-5" id="cart-total-{{ $product['id'] }}">
										{{ $fmt->formatCurrency($cart->total, 'USD') }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endif

			{{-- Update Button --}}
			{{-- <div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm" id="updateButton" style="justify-content: flex-end">
				<div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<!-- Button -->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
							Apply coupon
						</button>
					</div>
				</div>

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="updateCart">
						Update Cart
					</button>
				</div>
			</div> --}}

			<div id="updateButton"></div>

			<!-- Total -->
			@if($cartTotal !== 0)
				<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
					<h5 class="m-text20 p-b-24">
						Sub-Total
					</h5>

					<!-- Total -->
					<div class="flex-w flex-sb-m p-t-26 p-b-30" style="border-top: 1px dashed #d9d9d9;">
						<span class="m-text22 w-size19 w-full-sm">
							Total:
						</span>

						<span class="m-text21 w-size20 w-full-sm" id="cartTotal">
							{{ $fmt->formatCurrency($cartTotal, 'USD') }}
						</span>
					</div>

					<div class="size15 trans-0-4">
						<div id="checkoutButton"></div>
						<!-- Button -->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="checkoutOrderButton">
							Proceed to Checkout
						</button>
					</div>
				</div>
			@else
			<div id="checkoutButton"></div>
			@endif
		</div>
	</section>


  @include('layouts.includes.cartFooter')