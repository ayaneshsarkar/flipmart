@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="product__heading">
          <h2>{{ $title }}</h2>
        </div>
      </div>

      {{ Form::open(['action' => 'AuthController@updatePassword', 'method' => 'POST', 'class' => 'fullwidth']) }}
      
        {{-- Password --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('password')) ? '' : 'm-b-30' }}">
              <input type="password" class="product__inputbox_inner-input{{ ($errors->has('password')) ? '-danger' : '' }}" placeholder="Password" name="password" 
              value="{{ old('password') }}">
            </div>
            @error('password')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Confirm Password --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('confirm_password')) ? '' : 'm-b-30' }}">
              <input type="confirm_password" class="product__inputbox_inner-input{{ ($errors->has('confirm_password')) ? '-danger' : '' }}" placeholder="Confirm Password" name="confirm_password" 
              value="{{ old('confirm_password') }}">
            </div>
            @error('confirm_password')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Submit Button --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="product__buttonbox">
            <button type="submit" class="product__buttonbox_button">Update Password</button>
          </div>
        </div>

      {{ Form::close() }}
    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')