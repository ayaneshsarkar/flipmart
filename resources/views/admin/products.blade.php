@include('layouts.includes.admin.adminNavHeader')

<div class="item_wrap" id="mainItems">
  <div class="row">
    <div class="col-12">
      <div class="product__heading d-flex justify-content-between">
        <h2>View Products</h2>
        <h2><a href="/addproduct">Add Product</a></h2>
      </div>
    </div>

    @if(count($products))
      <div class="col-12">
        <div class="table-responsive-lg" style="padding: 0 20px;">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Category</th>
                <th>Vendor</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              @foreach($products as $product)
                <tr>
                  <td class="center">
                    <div class="d-flex align-items-center">
                      {{ $serial++ }}
                    </div>
                  </td>

                  <td class="content">
                    <div class="d-flex align-items-center">
                      <img src="{{ $product['image']['src'] }}" class="img-fluid img-thumbnail">
                      <div class="content">
                        <h3>{{ $product['title'] }}</h3>
                      </div>
                    </div>
                  </td>

                  <td class="center">
                    <div class="d-flex align-items-center">
                      ${{ $product['variants'][0]['price'] }}
                    </div>
                  </td>

                  <td class="center">
                    <div class="d-flex align-items-center">
                      {{ $product['product_type'] }}
                    </div>
                  </td>

                  <td class="center">
                    <div class="d-flex align-items-center">
                      {{ $product['vendor'] }}
                    </div>
                  </td>

                  <td class="center">
                    <div class="d-flex align-items-center">
                      <a href="/editproduct/?id={{ $product['id'] }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                      </a>
                    </div>
                  </td>
                  
                  <td class="center">
                    <div class="d-flex align-items-center">
                      <div class="d-flex align-items-center">
                        <a href="/deleteproduct/{{ $product['id'] }}">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
            
          </table>
        </div>
      </div>
    @endif

  </div>
</div>



@include('layouts.includes.admin.adminNavFooter')