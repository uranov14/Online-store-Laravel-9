@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h4 class="card-title">Images</h4>
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
              <h4 class="card-title d-flex justify-content-center">Add Images for {{ $product['product_name'] }}</h4>

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
                class="forms-sample" 
                action="{{ url('admin/add-images/'.$product['id']) }}"
                method="POST"
                enctype="multipart/form-data"
              >
                @csrf
                <div class="form-attr">
                  <div class="form-group">
                    <div class="form-group">
                        <label for="product_name" 
                          class="font-weight-bold"
                          style="margin: .1rem 0 0 0;"
                        >
                          Product Name:
                        </label>
                        &nbsp; {{ $product['product_name'] }}
                    </div>
                    <div class="form-group">
                        <label for="product_code"
                          class="font-weight-bold"
                          style="margin: .1rem 0 0 0;"
                        >
                          Product Code:
                        </label>
                        &nbsp; {{ $product['product_code'] }}
                    </div>
                    <div class="form-group">
                        <label for="product_color"
                          class="font-weight-bold"
                          style="margin: .1rem 0 0 0;"
                        >
                          Product Color:
                        </label>
                        &nbsp; {{ $product['product_color'] }}
                    </div>
                    <div class="form-group">
                        <label for="product_price"
                          class="font-weight-bold"
                          style="margin: .1rem 0 0 0;" 
                        >
                          Product Price:
                        </label>
                        &nbsp; {{ $product['product_price'] }}
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
                    <div class="field_wrapper">
                        <div>
                            <input type="file" id="images" name="images[]" multiple />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
              <br>
              <h4 class="card-title">Altenative Product Images</h4>
                <table id="products" class="table table-bordered">
                  <thead>
                      <tr>
                          <th>
                              ID
                          </th>
                          <th>
                              Image
                          </th>
                          <th>
                              Actions
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($product['images'] as $image)
                      <tr>
                          <td>
                              {{ $image['id'] }}
                          </td>
                          <td>
                              <img 
                                  src="{{ url('front/images/product_images/small/'.$image['image']) }}"
                              >
                          </td>
                          <td>
                              @if ($image['status'] == 1)
                              <a 
                                  class="updateImageStatus" 
                                  id="image-{{ $image['id'] }}" 
                                  image_id="{{ $image['id'] }}" 
                                  href="javascript:void(0)"
                              >
                                  <i class="mdi mdi-bookmark-check" status="Active"></i>
                              </a>
                              @else
                              <a 
                                  class="updateImageStatus" 
                                  id="image-{{ $image['id'] }}" 
                                  image_id="{{ $image['id'] }}" 
                                  href="javascript:void(0)"
                              >
                                  <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                              </a>
                              @endif
                              &nbsp;
                              <a 
                                  href="javascript:void(0)"
                                  class="confirmDelete"
                                  module="image"
                                  moduleId="{{ $image['id'] }}"
                              >
                                  <i class="mdi mdi-file-excel-box"></i>
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
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection