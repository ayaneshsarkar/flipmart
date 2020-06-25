@include('layouts.includes.admin.adminNavHeader')

<div class="item_wrap" id="mainItems">
  <div class="row">
    <div class="col-12">
      <div class="category__heading">
        <h2>Add Category</h2>
      </div>
    </div>

    {{ Form::open(['action' => 'ProductController@storeCategory', 'method' => 'POST', 
    'class' => 'fullwidth']) }}

      {{-- Gender --}}
      <div class="col-12">
        <div class="category__inputbox">
          <div class="category__inputbox_inner {{ ($errors->has('gender')) ? '' : 'm-b-30' }}">
            <input type="text" class="category__inputbox_inner-input{{ ($errors->has('gender')) ? '-danger' : '' }}" 
            placeholder="Gender (Ex: Women)" name="gender">
          </div>
          @error('gender')<span class="invalid-text">{{$message}}</span>@enderror
        </div>
      </div>

      {{-- Type --}}
      <div class="col-12">
        <div class="category__inputbox">
          <div class="category__inputbox_inner {{ ($errors->has('type')) ? '' : 'm-b-30' }}">
            <input type="text" class="category__inputbox_inner-input{{ ($errors->has('type')) ? '-danger' : '' }}" 
            placeholder="Shoe Type (Ex: Leather)" name="type">
          </div>
          @error('type')<span class="invalid-text">{{$message}}</span>@enderror
        </div>
      </div>

      {{-- Brand --}}
      <div class="col-12">
        <div class="category__inputbox">
          <div class="category__inputbox_inner {{ ($errors->has('brand')) ? '' : 'm-b-30' }}">
            <input type="text" class="category__inputbox_inner-input{{ ($errors->has('brand')) ? '-danger' : '' }}" 
            placeholder="Brand (Ex: Adidas)" name="brand">
          </div>
          @error('brand')<span class="invalid-text">{{$message}}</span>@enderror
        </div>
      </div>

      {{-- Info --}}
      <div class="col-12">
        <div class="category__inputbox">
          <div class="category__inputbox_text{{ ($errors->has('info')) ? '-danger' : ' m-b-30' }}">
            <textarea placeholder="Addotional Info (Optional)" name="info"></textarea>
          </div>
          @error('info')<span class="invalid-text">{{$message}}</span>@enderror
        </div>
      </div>
      
      {{-- Submit Button --}}
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="category__buttonbox">
          <button type="submit" class="category__buttonbox_button">ADD PRODUCT</button>
        </div>
      </div>

    {{ Form::close() }}

  </div>
</div>



@include('layouts.includes.admin.adminNavFooter')













