@include('layouts.includes.admin.adminNavHeader')

<div class="item_wrap" id="mainItems">
  <div class="row">
    <div class="col-12">
      <div class="category__heading d-flex justify-content-between">
        <h2>View Brands</h2>
        <h2><a href="/addcategory">Add Brand</a></h2>
      </div>
    </div>

    <div class="col-12">
      <div class="table-responsive" style="padding: 0 20px;">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Brand Name</th>
              <th>Created At</th>
              <th></th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @foreach($brands as $brand)
              <tr>
                <td>{{ $serial++ }}</td>
                <td>
                  <img 
                    src="{{ asset("brandimages/$brand->main_image") }}" 
                    alt="{{ $brand->brand }}" 
                    class="img"
                  >
                </td>
                <td class="center">{{ $brand->brand }}</td>
                <td class="center">{{ date('F j, Y, g:i a', strtotime($brand->created_at)) }}</td>
                <td class="center">
                  <a href="/editbrand/?id={{ $brand->id }}">
                    {{-- <i class="fa fa-pencil" aria-hidden="true"></i> --}} Edit
                  </a>
                </td>
                <td class="center">
                  <a class="alertswal" href="/deletebrand/{{ $brand->id }}">
                    {{-- <i class="fa fa-trash" aria-hidden="true"></i> --}} Delete
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>



@include('layouts.includes.admin.adminNavFooter')













