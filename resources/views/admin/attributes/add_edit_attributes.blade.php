@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <a href="{{ url('admin/products') }}" class="btn btn-dark" style="float: right">
            Back to Products
          </a>
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h4 class="card-title">Attributes</h4>
            </div>
            <div class="col-12 col-xl-4">
              <div class="justify-content-end d-flex">
                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                  <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                    <a class="dropdown-item" href="#">January - March</a>
                    <a class="dropdown-item" href="#">March - June</a>
                    <a class="dropdown-item" href="#">June - August</a>
                    <a class="dropdown-item" href="#">August - November</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title d-flex justify-content-center">Add Attributes for {{ $product['product_name'] }}</h4>

              @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong>{{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong>{{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif

              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif

              <form  
                action="{{ url('admin/add-attributes/'.$product['id']) }}"
                method="POST"
              >
                @csrf
                <div class="form-attr">
                  <div class="form-group">
                    <div class="form-group">
                        <label class="font-weight-bold" for="product_name" style="margin: .1rem 0 0 0;">Product Name:</label>&nbsp;{{ $product['product_name'] }}
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="product_code" style="margin: .1rem 0 0 0;">Product Code:</label>&nbsp;{{ $product['product_code'] }}
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="product_color" style="margin: .1rem 0 0 0;">Product Color:</label>&nbsp;{{ $product['product_color'] }}
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="product_price" style="margin: .1rem 0 0 0;">Product Price:</label>&nbsp;{{ $product['product_price'] }} $
                    </div>
                  </div>
                  <div class="d-flex align-items-center">
                    @if (!empty($product['product_image']))
                      <img 
                        src="{{ url('front/images/product_images/large/'.$product['product_image']) }}"
                        style="width: 60%;"
                      >
                    @else
                      <img 
                        src="{{ url('front/images/product_images/small/no-image.webp') }}"
                        style="width: 120px;"
                      >
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <h4 class="card-title">Add Attributes</h4>
                  <div class="field_wrapper">
                      <div>
                          <input type="text" class="input-attr" name="size[]" placeholder="Size" required/>
                          <input type="text" class="input-attr" name="sku[]" placeholder="SKU" required/>
                          <input type="text" class="input-attr" name="price[]" placeholder="Price" required/>
                          <input type="text" class="input-attr" name="stock[]" placeholder="Stock" required/>
                          <a href="javascript:void(0);" class="add_button" title="Add Attributes">
                              <i class="mdi mdi-plus-one"></i>
                          </a>
                      </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
              
              <hr class="hr-dark">

              <h4 class="card-title">Product Attributes</h4>
              <form method="post" action="{{ url('admin/edit-attributes/'.$product['id']) }}">
              @csrf
                <table id="products" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                            ID
                            </th>
                            <th>
                            Size
                            </th>
                            <th>
                            SKU
                            </th>
                            <th>
                            Price
                            </th>
                            <th>
                            Stock
                            </th>
                            <th>
                            Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product['attributes'] as $attribute)
                        <input 
                            type="number" 
                            name="attributeId[]" 
                            value="{{ $attribute['id'] }}" 
                            style="display: none;"
                        />
                        <tr>
                            <td>
                            {{ $attribute['id'] }}
                            </td>
                            <td>
                            {{ $attribute['size'] }}
                            </td>
                            <td>
                            {{ $attribute['sku'] }}
                            </td>
                            <td>
                              <input 
                                type="number" 
                                style="width: 70px;" name="price[]" 
                                value="{{ $attribute['price'] }}" 
                                required
                              />
                            </td>
                            <td>
                              <input 
                                type="number" 
                                style="width: 60px;" name="stock[]" 
                                value="{{ $attribute['stock'] }}" 
                                required
                              />
                            </td>
                            <td>
                            @if ($attribute['status'] == 1)
                            <a 
                                class="updateAttributeStatus" 
                                id="attribute-{{ $attribute['id'] }}" 
                                attribute_id="{{ $attribute['id'] }}" 
                                href="javascript:void(0)"
                            >
                                <i class="mdi mdi-bookmark-check" status="Active"></i>
                            </a>
                            @else
                            <a 
                                class="updateAttributeStatus" 
                                id="attribute-{{ $attribute['id'] }}" 
                                attribute_id="{{ $attribute['id'] }}" 
                                href="javascript:void(0)"
                            >
                                <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                            </a>
                            @endif
                            </td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Update Attributes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection