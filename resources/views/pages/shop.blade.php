@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
  @include('layouts.pages.modalSignUp')

  @php
		function sortClass($class) {
			if($class == 'low') {
				return 'lowSort';
			} elseif ($class == 'high') {
				return 'highSort';
			} else {
				return '';
			}
		}

		$minRange = $min ?? 10;
		$maxRange = $max ?? 50;

		$cartClass = 'errorCart';

		if(session('loggedIn') == TRUE) {
			$cartClass = 'successCart';
		}
  @endphp

	<!-- Title Page -->

	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" 
			style="background-image: linear-gradient(to right bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.6)), 
			url(images/shoes-all.jpg);">
		<h2 class="l-text2 t-center">
			{{ (in_array($category, ['all', 'men', 'women', 'kids'])) ? 'Welcome' : '' }}
		</h2>
		<p class="m-text13 t-center">
			{{ (in_array($category, ['all', 'men', 'women', 'kids'])) ? 
			"New Arrivals of " . date('Y') . ", Have a Look!" : '' }}
		</p>
	</section>

	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="leftbar p-r-20 p-r-0-sm">
						<!-- Categories -->
						<h4 class="m-text14 p-b-7">
							Categories
						</h4>

						<ul class="p-b-54">
							<li class="p-t-4">
								<a href="{{ URL::to('/shop?category_sort=all') }}" class="s-text13 {{ ($category == 'all') ? 'active1' : '' }}">
									All
								</a>
							</li>

							<li class="p-t-4">
								<a href="{{ URL::to('/shop?category_sort=women') }}" class="s-text13 {{ ($category == 'women') ? 'active1' : '' }}">
									Women
								</a>
							</li>

							<li class="p-t-4">
								<a href="{{ URL::to('/shop?category_sort=men') }}" class="s-text13 {{ ($category == 'men') ? 'active1' : '' }}">
									Men
								</a>
							</li>

							<li class="p-t-4">
								<a href="{{ URL::to('/shop?category_sort=kids') }}" id="categoryKids"  class="s-text13 {{ ($category == 'kids') ? 'active1' : '' }}">
									Kids
								</a>
							</li>

						</ul>


						<!--  -->
						<h4 class="m-text14 p-b-32">
							Filters
						</h4>

						<div class="filter-price p-t-22 p-b-50 bo3">
							<div class="m-text15 p-b-17">
								Price
							</div>

							<div class="wra-filter-bar">
								<div id="filter-bar"></div>
							</div>

							{{ Form::open(['action' => 'ShopsController@shop', 'method' => 'GET']) }}
								<div class="flex-sb-m flex-w p-t-16">
									<input type="hidden" name="min" id="minPrice">
									<input type="hidden" name="max" id="maxPrice">
									<div class="w-size11">
										<!-- Button -->
										<button type="submit" class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4">
											Filter
										</button>
									</div>

									<div class="s-text3 p-t-10 p-b-10">
										Range: $<span id="value-lower">610</span> - $<span id="value-upper">980</span>
									</div>
								</div>
							{{ Form::close() }}
						</div>

						{{-- <div class="filter-color p-t-22 p-b-50 bo3">
							<div class="m-text15 p-b-12">
								Color
							</div>

							<ul class="flex-w">
								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter1" type="checkbox" name="color-filter1">
									<label class="color-filter color-filter1" for="color-filter1"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter2" type="checkbox" name="color-filter2">
									<label class="color-filter color-filter2" for="color-filter2"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter3" type="checkbox" name="color-filter3">
									<label class="color-filter color-filter3" for="color-filter3"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter4" type="checkbox" name="color-filter4">
									<label class="color-filter color-filter4" for="color-filter4"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter5" type="checkbox" name="color-filter5">
									<label class="color-filter color-filter5" for="color-filter5"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter6" type="checkbox" name="color-filter6">
									<label class="color-filter color-filter6" for="color-filter6"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter7" type="checkbox" name="color-filter7">
									<label class="color-filter color-filter7" for="color-filter7"></label>
								</li>
							</ul>
						</div> --}}
					</div>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">

					<!-- Sort By Price -->
					<div class="flex-sb-m flex-w p-b-35">
						<div class="flex-w" style="align-items: center">
							<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
								<select onchange="sortSelectFunction()" class="selection-2 {{ sortClass($sortClass) }}" name="sorting">
									<option>Default Sorting</option>
									<option>Price: low to high</option>
									<option>Price: high to low</option>
								</select>
							</div>

							{{-- <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
								<select class="selection-2" name="sorting">
									<option>Price</option>
									<option>$0.00 - $50.00</option>
									<option>$50.00 - $100.00</option>
									<option>$100.00 - $150.00</option>
									<option>$150.00 - $200.00</option>
									<option>$200.00+</option>

								</select>
							</div> --}}

							<div class="search-product pos-relative bo4 of-hidden m-t-5 m-b-5" style="height: 50px">
								<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search Products..." style="height: 100%">
	
								<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
									<i class="fs-12 fa fa-search" aria-hidden="true"></i>
								</button>
							</div>

							<div style="display: none">
								{{ Form::open(['action' => 'ShopsController@shop', 'method' => 'GET', 'id' => 'sortForm']) }}
									<input type="hidden" id="sortResult" name="price_sort">
								{{ Form::close() }}
							</div>

							<p id='test'></p>
						</div>

						<span class="s-text8 p-t-5 p-b-5">
							Showing 1–3 of 5 results
						</span>
					</div>

					<!-- Product -->
					<div class="row">
						@if(count($products['products']) == 0)

							<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
								<p>No Results Found</p>
							</div>

						@else

							@foreach ($products['products'] as $product)				

								<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
									<!-- Block2 -->
									<div class="block2">
										<div class="block2-img wrap-pic-w of-hidden pos-relative">
											<img src="{{ $product['image']['src'] }}" 
											alt="{{ $product['title'] }}">

											<div class="block2-overlay trans-0-4 no-cart">
												<div class="block2-btn-addcart w-size1 trans-0-4">
													<button 
													class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 cartButton"
													data-shopify={{ $product['id'] }}>
														Add to Cart
													</button>
												</div>
											</div>
										</div>

										<div class="block2-txt p-t-20">
											<a href="{{ URL::to("/shop/" . strtolower($product['id'])) }}" class="block2-name dis-block s-text3 p-b-5">
												{{ $product['title'] }}
											</a>

											@if($product['variants'][0]['compare_at_price'] !== 
											$product['variants'][0]['price'])
												<span class="block2-oldprice m-text7 p-r-5">
													${{ $product['variants'][0]['compare_at_price'] }}
												</span>

												<span class="block2-newprice m-text8 p-r-5">
													${{ $product['variants'][0]['price'] }}
												</span>
											@else
												<span class="block2-price m-text6 p-r-5">
													${{ $product['variants'][0]['price'] }}
												</span>
											@endif
										</div>
									</div>
								</div>

							@endforeach
						
						@endif

					</div>

					<!-- Pagination -->
					<div class="pagination flex-m flex-w p-t-26">
						{{-- {{ $products->links('vendor.pagination.custom') }} --}}
					</div>
				</div>
			</div>
		</div>
	</section>

  @include('layouts.includes.shopFooter')