@include('layouts.includes.admin.adminNavHeader')

<div class="item_wrap" id="mainItems">
  <div class="row">
    <div class="col-12">
      <div class="category__heading">
        <h2>Add Brand</h2>
      </div>
    </div>

    {{ Form::open(['action' => 'ProductController@storeCategory', 'method' => 'POST', 
    'class' => 'fullwidth']) }}

      {{-- Brand --}}
      <div class="col-12">
        <div class="category__inputbox">
          <div class="category__inputbox_inner {{ ($errors->has('brand')) ? '' : 'm-b-30' }}">
            <input type="text" class="category__inputbox_inner-input{{ ($errors->has('brand')) ? '-danger' : '' }}" 
            placeholder="Brand (Ex: Adidas)" name="brand" value="{{ old('brand') }}">
          </div>
          @error('brand')<span class="invalid-text">{{$message}}</span>@enderror
        </div>
      </div>
      
      {{-- Submit Button --}}
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="category__buttonbox">
          <button type="submit" class="category__buttonbox_button">ADD BRAND</button>
        </div>
      </div>
      

    {{ Form::close() }}

  </div>
</div>



@include('layouts.includes.admin.adminNavFooter')













