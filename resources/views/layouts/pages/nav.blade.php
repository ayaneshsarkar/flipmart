<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
					<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
					<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
					<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
				</div>

				<span class="topbar-child1">
					Free shipping for standard order over $100
				</span>

				<div class="topbar-child2">
					<span class="topbar-email">
						@if(session('userId'))
							{{ DB::table('users')->where('id', session('userId'))->first()->email }}
						@else
							Please Sign In or Create an Account
						@endif
					</span>
				</div>
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="{{ URL::to('/') }}" class="logo logoText">
					{{-- <img src="{{ asset('images/icons/logo.png') }}" alt="IMG-LOGO"> --}}
					FLIPMART
				</a>

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li class="{{ (!empty($page) && $page == 'home') ? 'sale-noti' : '' }}">
								<a href="{{ URL::to('/') }}">Home</a>
							</li>

							<li class="{{ (!empty($page) && $page == 'shop') ? 'sale-noti' : '' }}">
								<a href="{{ URL::to('/shop') }}">Shop</a>
              </li>
              
              <li class="{{ (!empty($page) && $page == 'category') ? 'sale-noti' : '' }}">
                <a href="#" id="categoryAll">Categories</a>
                <ul class="sub_menu">
									<li><a href="/shop?category=men" id="categoryMen">Menz Footear</a></li>
									<li><a href="/shop?category=women" id="categoryWomen">Womenz Footwear</a></li>
									<li><a href="/shop?category=kids" id="categoryKids">Kidz Footear</a></li>
								</ul>

								<div style="display: none">
									{{ Form::open(['action' => 'ShopsController@shop', 'method' => 'GET', 'id' => 'categoryForm']) }}
										<input type="text" id="categoryResult" name="category_sort" hidden="hidden">
									{{ Form::close() }}
								</div>
              </li>

							<li class="{{ (!empty($page) && $page == 'about') ? 'sale-noti' : '' }}">
								<a href="{{ URL::to('/about') }}">About</a>
							</li>

							<li class="{{ (!empty($page) && $page == 'contact') ? 'sale-noti' : '' }}">
								<a href="{{ URL::to('/contact') }}">Contact</a>
							</li>

							<li class="{{ (!empty($page) && $page == 'cart') ? 'sale-noti' : '' }}">
								<a href="{{ URL::to('/cart') }}">Cart</a>
              </li>
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->
				<div class="header-icons">

					@if(session('loggedIn') == TRUE)
						<div style="position: relative">
							<a id="account" class="header-wrapicon1 dis-block">
								<img src="{{ asset('images/icons/icon-header-01.png') }}" class="header-icon1" alt="ICON">
							</a>
							@include('layouts.includes.accountDropdown')
						</div>

						@if(!empty($page) && $page != 'cart')

							<span class="linedivide1"></span>

							<div class="header-wrapicon2">
								<img src="{{ asset('images/icons/icon-header-02.png') }}" class="header-icon1 js-show-header-dropdown" alt="ICON">
								<span class="header-icons-noti" id="cartCount">{{ $cartCount ?? 0 }}</span>

								{{-- Header Cart Noti --}}
								@include('layouts.includes.cartDropdown')
							</div>

						@endif
						
					@else

						<a style="cursor: pointer" id="modalBtnSignUp" class="modalBtn header-wrapicon1 dis-block">
							SIGN UP
						</a>
						<span class="linedivide1"></span>
						<a style="cursor: pointer" id="modalBtnSignIn" class="modalBtn header-wrapicon1 dis-block">
							SIGN IN
						</a>

					@endif
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="/" class="logoText">
				FLIPMART
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
					<div class="header-icons-mobile">
						@if(!session('loggedIn'))
							<a class="header-wrapicon1 dis-block" id="modalBtnSignUpMb" style="cursor: pointer">
								SIGN UP
							</a>

							<span class="linedivide2"></span>

							<div class="header-wrapicon2" id="modalBtnSignInMb" style="cursor: pointer">
								SIGN IN
							</div>
						@else
							@if($page && $page != 'cart')
								<div class="header-wrapicon2">
									<img src="{{ asset('images/icons/icon-header-02.png') }}" class="header-icon1 js-show-header-dropdown" alt="ICON">
									<span class="header-icons-noti" id="cartCountMb">{{ $cartCount ?? 0 }}</span>

									{{-- Header Cart Noti --}}
									@include('layouts.includes.cartDropdownMb')
								</div>
							@endif
						@endif
					</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<span class="topbar-child1">
							Free shipping for standard order over $100
						</span>
					</li>

					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
							<span class="topbar-email">
								ayaneshofficial@gmail.com
							</span>

							{{-- <div class="topbar-language rs1-select2">
								<select class="selection-1" name="time">
									<option>USD</option>
									<option>INR</option>
								</select>
							</div> --}}
						</div>
					</li>

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook"></a>
							<a href="#" class="topbar-social-item fa fa-instagram"></a>
							<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
							<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
							<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
						</div>
					</li>

					<li class="item-menu-mobile">
						<a href="/">Home</a>
						{{-- <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i> --}}
					</li>

					<li class="item-menu-mobile">
						<a href="/shop">Shop</a>
          </li>
          
          <li class="item-menu-mobile">
            <a>Categories</a>
            <ul class="sub-menu">
							<li><a href="#">Menz Wear</a></li>
							<li><a href="#">Womenz Wear</a></li>
							<li><a href="#">Kidz Wear</a></li>
						</ul>
          </li>


					<li class="item-menu-mobile">
						<a href="/about">About</a>
					</li>

					<li class="item-menu-mobile">
						<a href="/contact">Contact</a>
					</li>

					<li class="item-menu-mobile">
						<a href="/cart">Cart</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>