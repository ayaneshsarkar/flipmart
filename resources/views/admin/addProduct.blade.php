@include('layouts.includes.admin.adminNavHeader')

  <div class="item_wrap" id="mainItems">
    <div class="row">
      <div class="col-12">
        <div class="product__heading">
          <h2>Add Product</h2>
        </div>
      </div>

      <div class="col-12">
        <div class="product__inputbox">
          <div class="product__inputbox_inner">
            <input type="text" class="product__inputbox_inner-input" placeholder="Title" name="title">
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="product__inputbox">
            <div class="product__inputbox_filebox">
              <input type="file" name="main_image" id="productFile" hidden="hidden">
              <button type="button" id="productButton" class="product__inputbox_filebox-button">
                <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
              </button>
              <span id="productText" class="product__inputbox_filebox-text">Choose Main File [No File Chosen Yet]
              </span>
            </div>
        </div>
      </div>

      <div class="col-12">
        <div class="product__inputbox">
            <div class="product__inputbox_filebox">
              <input type="file" name="images[]" id="productFiles" hidden="hidden" multiple>
              <button type="button" id="productButtons" class="product__inputbox_filebox-button">
                <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
              </button>
              <span id="productTexts" class="product__inputbox_filebox-text">Choose Files [No File(s) Chosen Yet]
              </span>
            </div>
        </div>
      </div>

      <div class="col-12">
        <div class="product__inputbox">
          <div class="product__inputbox_text">
            <textarea placeholder="Description" name="desc"></textarea>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="product__inputbox">
          <div class="product__inputbox_text">
            <textarea placeholder="Additional Info (Optional)" name="info"></textarea>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="product__buttonbox">
          <button type="submit" class="product__buttonbox_button">ADD PRODUCT</button>
        </div>
      </div>

    </div>
  </div>



@include('layouts.includes.admin.adminNavFooter')