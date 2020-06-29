@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="product__heading">
          <h2>Add Product</h2>
        </div>
      </div>

      {{ Form::open(['action' => 'ProductController@storeProduct', 'method' => 'POST', 'class' => 'fullwidth', 'enctype' => 'multipart/form-data']) }}

        {{-- Title --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('title')) ? '' : 'm-b-30' }}">
              <input type="text" class="product__inputbox_inner-input{{ ($errors->has('title')) ? '-danger' : '' }}" placeholder="Title" name="title" value="{{ old('title') }}">
            </div>
            @error('title')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Sizes --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('min_size')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Min Size</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="min_size" 
              value="{{ old('min_size') }}">
            </div>
            @error('min_size')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('max_size')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Max Size</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="max_size" 
              value="{{ old('max_size') }}">
            </div>
            @error('max_size')<span class="invalid-text">{{$message}}</span>@enderror
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

        {{-- Images --}}

        <div class="col-12">
          <div class="product__inputbox">
              <div class="product__inputbox_filebox {{ ($errors->has('images')) ? 'danger' : 'm-b-30' }}" id="fileboxes">
                <input type="file" name="images[]" id="productFiles" hidden="hidden" multiple>
                <button type="button" id="productButtons" class="product__inputbox_filebox-button">
                  <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                </button>
                <span id="productTexts" class="product__inputbox_filebox-text">Choose Files [No File(s) Chosen Yet]
                </span>
              </div>
              @error('images')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Category --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_option {{ $errors->has('category') ? 'danger' : '' }}" id="categoryOptions">
              <input type="text" name="category" id="categoryInput" hidden="hidden">
              <p id="categoryText">{{ old('category') ?? 'Choose Category (Required)' }}</p>
              <span class="icon"><i class="fa fa-angle-down select_arrow" aria-hidden="true"></i></span>
            </div>

            <div class="product__inputbox_option optionbox">Men</div>
            <div class="product__inputbox_option optionbox">Women</div>
            <div class="product__inputbox_option optionbox">Kids</div>
            @error('category')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Type --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_option {{ $errors->has('type') ? 'danger' : '' }}" id="typeOptions">
              <input type="text" name="type" id="typeInput" style="display: none">
              <p id="typeText">{{ old('type') ?? 'Choose Type (Required)' }}</p>
              <span class="icon"><i class="fa fa-angle-down select_arrow" aria-hidden="true"></i></span>
            </div>

            @if(!empty($categories))
              @foreach ($categories as $category)
                <div class="product__inputbox_option optionbox">{{ $category->type }}</div>
              @endforeach
              @error('type')<span class="invalid-text">{{$message}}</span>@enderror
            @endif
          </div>
        </div>

        {{-- Brand --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_option {{ $errors->has('brand') ? 'danger' : '' }}" id="brandOptions">
              <input type="text" name="brand" id="brandInput" hidden="hidden">
              <p id="brandText">{{ old('brand') ?? 'Choose Brand (Required)' }}</p>
              <span class="icon"><i class="fa fa-angle-down select_arrow" aria-hidden="true"></i></span>
            </div>

            @if(!empty($categories))
              @foreach ($categories as $category)
                <div class="product__inputbox_option optionbox">{{ $category->brand }}</div>
              @endforeach
              @error('brand')<span class="invalid-text">{{$message}}</span>@enderror
            @endif
          </div>
        </div>


        {{-- Description --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_text{{ ($errors->has('description')) ? '-danger' : ' m-b-30' }}">
              <textarea placeholder="Description" name="description">{{ old('description') }}</textarea>
            </div>
            @error('description')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Info --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_text{{ ($errors->has('info')) ? '-danger' : ' m-b-30' }}">
              <textarea placeholder="Additional Info (Optional)" name="info">{{ old('info') }}</textarea>
            </div>
            @error('info')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Submit Button --}}

        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="product__buttonbox">
            <button type="submit" class="product__buttonbox_button">ADD PRODUCT</button>
          </div>
        </div>

      {{ Form::close() }}

    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')