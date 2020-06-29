@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
  @include('layouts.pages.modalSignUp')

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: linear-gradient(to right bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.7)), 
  url(images/about-1.jpg);">
		<h2 class="l-text2 t-center">
			About
		</h2>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-38">
		<div class="container">
			<div class="row">
				<div class="col-md-4 p-b-30">
					<div class="hov-img-zoom" style="background: black">
						<img src="{{ asset("images/about-2.jpg") }}" alt="IMG-ABOUT" style="opacity: 0.75">
					</div>
				</div>

				<div class="col-md-8 p-b-30">
					<h3 class="m-text26 p-t-15 p-b-16">
						Our story
					</h3>

					<p class="p-b-12">
						Flipmart is India’s leading e-commerce marketplace offering over 30 million products of shoes. Flipmart is known for its path-breaking services like Cash on Delivery. Flipmart is the only online player offering services like In-a-Day Guarantee (50 cities) and Same-Day-Guarantee (13 cities) at scale. Its annual subscription service, Flipmart First, is the first of its kind in the country.<br><br>

            Launched in October 2020, Flipmart has become the preferred online marketplace for leading Indian and international brands.<br><br>

            Flipmart, currently 33,000 people strong, has 75 million registered users clocking over 10 million daily visits.<br>
					</p>

					<div class="bo13 p-l-29 m-l-9 p-b-10">
						<p class="p-b-11">
							Creativity is just connecting things. When you ask creative people how they did something, they feel a little guilty because they didn't really do it, they just saw something. It seemed obvious to them after a while.
						</p>

						<span class="s-text7">
							- Steve Job’s
						</span>
					</div>
				</div>
			</div>
		</div>
  </section>
  
  @include('layouts.includes.footer')


	
