@include('layouts.includes.admin.adminNavHeader')

<div class="item_wrap" id="mainItems">
  <div class="row">
    <div class="col-12">
      <div class="category__heading">
        <h2>Add Brand</h2>
      </div>
    </div>

    {{ Form::open(['action' => 'ProductController@storeCategory', 'method' => 'POST', 
    'class' => 'fullwidth', 'enctype' => 'multipart/form-data']) }}

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

      {{-- Main Image --}}

      <div class="col-12">
        <div class="product__inputbox">
            <div class="product__inputbox_filebox {{ ($errors->has('main_image')) ? 'danger' : 'm-b-30' }}" id="filebox">
              <input type="file" name="main_image" id="productFile" hidden="hidden">
              <button type="button" id="productButton" class="product__inputbox_filebox-button">
                <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
              </button>
              <span id="productText" class="product__inputbox_filebox-text">Choose Main File [No File Chosen Yet]
              </span>
            </div>
            @error('main_image')<span class="invalid-text">{{$message}}</span>@enderror
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













