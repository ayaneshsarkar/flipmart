@include('layouts.includes.header')

	<!-- Nav -->
	@include('layouts.pages.nav')

	{{-- Modal --}}
	@include('layouts.pages.modalSignIn')
  @include('layouts.pages.modalSignUp')

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: linear-gradient(to right bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.6)), 
  url(images/contact-1.jpg);">
		<h2 class="l-text2 t-center">
			Contact
		</h2>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-30">
		<div class="container">
			<div class="row">

				@if(!empty(Session::get('contactSuccess')))
					<div class="col-12" id="contactSuccess">
						<div class="contactSuccess {{ (Session::get('contactSuccess') == 'FALSE') ? 'danger' : '' }}">
							@if(Session::get('contactSuccess') == 'TRUE')
								<p>Successfully Sent Mail!</p>
							@else
								<p>Could Not Send Mail!</p>
							@endif

							<a href="#" id="contactCross"><p>x</p></a>
						</div>
					</div>
				@endif

				{{-- <div class="col-md-6 p-b-30">
					<div class="p-r-20 p-r-0-lg">
						<div class="contact-map size21" id="google_map" data-map-x="40.614439" data-map-y="-73.926781" data-pin="images/icons/icon-position-map.png" data-scrollwhell="0" data-draggable="1"></div>
					</div>
				</div> --}}

				<div class="col-md-12 p-b-30">

					{{ Form::open(['action' => 'PagesController@storeMessage', 'method' => 'POST', 
    				'class' => 'leave-comment']) }}

						<div class="m-text26 p-b-36 p-t-15 contactTitleBox">
							<h4 class="contactTitle">Send us your message</h4>
						</div>

						<div class="bo4 of-hidden size15 {{ ($errors->has('fullname')) ? 'borderDanger' : 'm-b-20' }}">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="fullname" placeholder="Full Name"
							value="{{ old('fullname') }}">
						</div>
						@error('fullname')<span class="invalid-text" style="margin-bottom: 20px">{{ $message }}</span>@enderror

						<div class="bo4 of-hidden size15 {{ ($errors->has('phone_number')) ? 'borderDanger' : 'm-b-20' }}">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
						</div>
						@error('phone_number')
							<span class="invalid-text" style="margin-bottom: 20px">
								{{ $message }}
							</span>
						@enderror

						<div class="bo4 of-hidden size15 {{ ($errors->has('email')) ? 'borderDanger' : 'm-b-20' }}">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="email" placeholder="Email Address"
							value="{{ old('email') }}">
						</div>
						@error('email')<span class="invalid-text" style="margin-bottom: 20px">{{ $message }}</span>@enderror

						<textarea class="dis-block s-text7 size20 bo4 p-l-22 p-r-22 p-t-13 
						{{ ($errors->has('message')) ? 'borderDanger' : 'm-b-20' }}" 
						name="message" 
						placeholder="Message">{{ old('message') }}</textarea>
						@error('message')<span class="invalid-text" style="margin-bottom: 20px">{{ $message }}</span>@enderror

						<div class="w-size25">
							<!-- Button -->
							<button type="submit" class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4">
								Send
							</button>
						</div>

						{{ Form::close() }}

				</div>
			</div>
		</div>
	</section>

  @include('layouts.includes.footer')
