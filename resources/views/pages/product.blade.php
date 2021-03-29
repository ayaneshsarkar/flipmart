@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
	@include('layouts.pages.modalSignUp')

  <!-- Breadcrumb -->
	<div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
		<a href="{{ URL::to('/') }}" class="s-text16">
			Home
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="{{ URL::to('/shop?category_sort=' . strtolower($product['product_type'])) }}" class="s-text16">
			{{ ucwords($product['product_type']) }}
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="#" class="s-text16">
			{{ ucwords($product['vendor']) }}
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<span class="s-text17">
      {{ $product['title'] }}
		</span>
	</div>

	<!-- Product Detail -->
	<div class="container bgwhite p-t-35 p-b-80">
		<div class="flex-w flex-sb">
			<div class="w-size13 p-t-30 respon5">
				<div class="wrap-slick3 flex-sb flex-w">
					<div class="wrap-slick3-dots"></div>

					<div class="slick3">
						<div class="item-slick3" data-thumb="{{ $product['image']['src'] }}">
							<div class="wrap-pic-w">
								<img src="{{ $product['image']['src'] }}" alt="IMG-PRODUCT">
							</div>
						</div>

						@foreach ($productImages as $key => $image)
							@if($key >= 1) 
								<div class="item-slick3" data-thumb="{{ $image['src'] }}">
									<div class="wrap-pic-w">
										<img src="{{ $image['src'] }}" alt="IMG-PRODUCT">
									</div>
								</div>
							@endif
						@endforeach

					</div>
				</div>
			</div>

			<div class="w-size14 p-t-30 respon5">
				<h4 class="product-detail-name m-text16 p-b-13">
					{{ $product['title'] }}
				</h4>

				<span class="m-text17">
					${{ $product['variants'][0]['price'] }}
				</span>

				<p class="s-text8 p-t-10">
					{{ $product['body_html'] ?? '' }}
				</p>

				<!-- Size -->
				<div class="p-t-33 p-b-60">
					<div class="flex-m flex-w p-b-10">
						<div class="s-text15 w-size15 t-center">
							Size
						</div>

						<div class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
							<select class="selection-2" id="singleProductSize" name="size">
                <option value="null">Choose an option</option>
                @php
                  $minSize = $productData->min_size;
                  $maxSize = $productData->max_size;
                  for($size = $minSize; $size <= $maxSize; $size++) {
                    echo "<option>" . $size ."</option>";
                  }
                @endphp
							</select>
						</div>
					</div>

					<div class="flex-r-m flex-w p-t-10">
						<div class="w-size16 flex-m flex-w">
							<div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
								<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
								</button>

								<input class="size8 m-text18 t-center num-product" id="singleProductQuantity" type="number" name="num-product" value="1">

								<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>

							<a href="#"  id="singleCartButton" class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
								<!-- Button -->
								<button type="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
									Add to Cart
								</button>
							</a>
						</div>
					</div>
				</div>

				<div class="p-b-45">
					{{-- <span class="s-text8 m-r-35">SKU: MUG-01</span> --}}
					<span class="s-text8">Category: {{ $product['product_type'] }}</span>
				</div>

				<!--  -->
				<div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
					<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Description
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
					</h5>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8">
							{{ $product['body_html'] }}
						</p>
					</div>
        </div>
			</div>
		</div>
	</div>
	<input type="hidden" name="productSlug" id="singleProductSlug" value="{{ $product['id'] }}">
  
  @include('layouts.includes.productFooter')