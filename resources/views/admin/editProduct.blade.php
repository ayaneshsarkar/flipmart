@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="product__heading">
          <h2>Edit Product</h2>
        </div>
      </div>

      {{ Form::open(['action' => 'ProductController@updateProduct', 'method' => 'POST', 'class' => 'fullwidth', 'enctype' => 'multipart/form-data']) }}

        {{-- Id --}}
        <input type="hidden" name="id" value={{ $product['id'] }}>

        {{-- Title --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_inner {{ ($errors->has('title')) ? '' : 'm-b-30' }}">
              <input type="text" class="product__inputbox_inner-input{{ ($errors->has('title')) ? '-danger' : '' }}" placeholder="Title" name="title" 
              value="{{ $product['title'] }}">
            </div>
            @error('title')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Price --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('price')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Price</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="price" 
              value="{{ round($product['variants'][0]['compare_at_price']) }}">
            </div>
            @error('price')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Discount --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('discount')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Discount (Optional)</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="discount" 
              value="{{ $productDiscount }}">
            </div>
            @error('discount')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Delivery Days --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('delivery_days')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Delivery Days</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="delivery_days" 
              value="{{ $productData->delivery_days }}">
            </div>
            @error('delivery_days')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>


        {{-- Sizes --}}

        <div class="col-md-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('min_size')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Min Size</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="min_size" 
              value="{{ $productData->min_size }}">
            </div>
            @error('min_size')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        <div class="col-md-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('max_size')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Max Size</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="max_size" 
              value="{{ $productData->max_size }}">
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
              <span id="productText" class="product__inputbox_filebox-text">
                {{ $mainImage ?? "Choose Main File [No File Chosen Yet]" }}
              </span>
            </div>
            @error('main_image')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        <div class="col-12">
          <div class="mainProductImage">
            <div class="imgBox" id="{{ $product['image']['id'] }}">
              <img 
                src="{{ $product['image']['src'] }}" 
                alt="{{ $product['title'] }}" 
                class="img-fluid img-thumbnail"
              >

              <div class="cross productImageCross"
              data-product={{ $product['id'] }} data-image="{{ $product['image']['id'] }}">
                <i class="fa fa-times" aria-hidden="true"></i>
              </div>
            </div>
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
                <span id="productTexts" class="product__inputbox_filebox-text">
                  {{ $productImageStrings ?? "Choose Files [No File(s) Chosen Yet]" }}
                </span>
              </div>
              @error('images')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        @if(!empty($productImages))
          <div class="col-12">
            <div class="mainProductImage">
              @foreach($productImages as $image)
                @if($image['position'] !== 1)
                  <div class="imgBox" id="{{ $image['id'] }}">
                    <img 
                      src="{{ $image['src'] }}" 
                      alt="{{ $product['title'] }}" 
                      class="img-fluid img-thumbnail"
                    >

                    <div class="cross productImageCross" data-product={{ $product['id'] }} data-image="{{ $image['id'] }}" data-name={{ $image['src'] }}>
                      <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>
        @endif

        {{-- Availability --}}
        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_number {{ ($errors->has('availability')) ? 'danger' : 'm-b-30' }}">
              <div class="labelbox">
                <span>Availability</span>
              </div>
              <input type="number" class="product__inputbox_number-input" name="availability" 
              value="{{ $product['variants'][0]['inventory_quantity'] }}">
            </div>
            @error('availability')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Category --}}
        <div class="col-12">
          <div class="product__inputbox">
            <select name="category" 
            class="product__inputbox__newoption{{ $errors->has('category') ? ' danger' : '' }}" 
            required>
              <option disabled selected value="">Choose Category (Required)</option>
              <option value="Men" {{ $product['product_type'] === 'Men' ? 'selected' : '' }}>
                Men
              </option>
              <option value="Women" 
              {{ $product['product_type'] === 'Women' ? 'selected' : '' }}>
                Women
              </option>
              <option value="Kids" {{ $product['product_type'] === 'Kids' ? 'selected' : '' }}>
                Kids
              </option>
            </select>
            @error('category')<span class="invalid-text">{{$message}}</span>@enderror   
          </div>
        </div>

        {{-- Brand --}}

        <div class="col-12">
          <div class="product__inputbox">
            <select name="brand" class="product__inputbox__newoption" required>
              <option disabled selected value="">Choose Brand (Selected)</option>
              @if(!empty($categories))
                @foreach ($categories as $category)
                  <option value="{{ $category->brand }}"
                  {{ $product['vendor'] === $category->brand ? 'selected' : '' }}>
                    {{ $category->brand }}
                  </option>
                @endforeach
              @endif
            </select>
            @error('brand')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Featured --}}
        <div class="col-12">
          <div class="product__inputbox">
            <select name="featured" class="product__inputbox__newoption" required>
              <option disabled selected value="">Select Featured (Required)</option>
              <option value="0" {{ !$productData->featured ? 'selected' : '' }}>No</option>
              <option value="1" {{ $productData->featured ? 'selected' : '' }}>Yes</option>
            </select>
            @error('featured')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>


        {{-- Description --}}

        <div class="col-12">
          <div class="product__inputbox">
            <div class="product__inputbox_text{{ ($errors->has('description')) ? '-danger' : ' m-b-30' }}">
              <textarea placeholder="Description" name="description">{{ $product['body_html'] }}</textarea>
            </div>
            @error('description')<span class="invalid-text">{{$message}}</span>@enderror
          </div>
        </div>

        {{-- Submit Button --}}

        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="product__buttonbox">
            <button type="submit" class="product__buttonbox_button">UPDATE PRODUCT</button>
          </div>
        </div>

      {{ Form::close() }}

    </div>
  </div>

@include('layouts.includes.admin.adminNavFooter')