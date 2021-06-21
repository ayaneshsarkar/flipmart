@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="product__heading profile d-flex justify-content-between">
          <h2>{{ $title }}</h2>
          <h2><a href="/change-password">Change Password</a></h2>
        </div>
      </div>

      {{ Form::open(['action' => 'AuthController@updateProfile', 'method' => 'POST', 'class' => 'fullwidth']) }}
      
        {{-- Name --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('name')) ? '' : 'm-b-30' }}">
              <input type="text" class="product__inputbox_inner-input{{ ($errors->has('name')) ? '-danger' : '' }}" placeholder="name" name="name" 
              value="{{ $user->name }}">
            </div>
            @error('name')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Email --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('email')) ? '' : 'm-b-30' }}">
              <input type="email" class="product__inputbox_inner-input{{ ($errors->has('email')) ? '-danger' : '' }}" placeholder="Email" name="email" 
              value="{{ $user->email }}">
            </div>
            @error('email')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- City --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('city')) ? '' : 'm-b-30' }}">
              <input type="text" class="product__inputbox_inner-input{{ ($errors->has('city')) ? '-danger' : '' }}" placeholder="City" name="city" 
              value="{{ $user->city ?? '' }}">
            </div>
            @error('city')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- State --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('state')) ? '' : 'm-b-30' }}">
              <input type="text" class="product__inputbox_inner-input{{ ($errors->has('state')) ? '-danger' : '' }}" placeholder="State" name="state" 
              value="{{ $user->state ?? '' }}">
            </div>
            @error('state')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Pincode --}}
        <div class="col-md-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('pincode')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>PIN</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="pincode" 
              value="{{ $user->pincode }}">
            </div>
            @error('pincode')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Phone Number --}}
        <div class="col-md-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('phone_number')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="phone_number" 
              value="{{ $user->phone_number ?? null }}">
            </div>
            @error('phone_number')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Description --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_text{{ ($errors->has('address')) ? '-danger' : ' m-b-30' }}">
              <textarea placeholder="Address" name="address">{{ $user->address }}</textarea>
            </div>
            @error('address')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Submit Button --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="product__buttonbox">
            <button type="submit" class="product__buttonbox_button">Update</button>
          </div>
        </div>

      {{ Form::close() }}
    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')