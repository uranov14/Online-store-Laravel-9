@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <a href="{{ url('admin/products') }}" class="btn btn-dark">
                Back to Products
              </a>
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
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">{{ $title }}</h4>

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
                @if (empty($product['id']))
                action="{{ url('admin/add-edit-product') }}"
                @else
                action="{{ url('admin/add-edit-product/'.$product['id']) }}"    
                @endif
                method="post"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label for="category_id">Select Category</label>
                  <select class="form-control text-dark"  name="category_id" id="category_id">
                    <option value="" style="display: none">Select</option> 
                    @foreach ($categories as $section)
                      <optgroup label="{{ $section['name'] }}"></optgroup>
                      @foreach ($section['categories'] as $category)
                        <option 
                          @if (!empty($product['category_id']) && $product['category_id'] == $category['id'])
                            selected
                          @endif 
                          value="{{ $category['id'] }}"
                        >
                          &nbsp;&nbsp;-&nbsp;{{ $category['category_name'] }}
                        </option>
                        @foreach ($category['sub_categories'] as $subcategory)
                          <option 
                            @if (!empty($product['category_id']) && $product['category_id'] == $subcategory['id'])
                              selected
                            @endif
                            value="{{ $subcategory['id'] }}"
                          >
                            &nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{ $subcategory['category_name'] }}
                          </option>
                        @endforeach
                      @endforeach
                    @endforeach
                  </select>
                </div>
                <div class="loadFilters">
                  @include('admin.filters.category_filters')
                </div>
                <div class="form-group">
                  <label for="brand_id">Select Brand</label>
                  <select class="form-control text-dark"  name="brand_id" id="brand_id">
                    <option value="" style="display: none">Select</option>
                    @foreach ($brands as $brand)
                      <option 
                      @if (!empty($product['brand_id']) && $product['brand_id'] == $brand['id'])
                        selected
                      @endif
                      value="{{ $brand['id'] }}"
                      >
                        {{ $brand['name'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="product_name">Product Name</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_name']))
                    value="{{ $product['product_name'] }}"
                    @else
                    value="{{ old('product_name') }}"   
                    @endif 
                    name="product_name" 
                    id="product_name" 
                    placeholder="Enter Product Name"
                  >
                </div>
                <div class="form-group">
                  <label for="product_code">Product Code</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_code']))
                    value="{{ $product['product_code'] }}"
                    @else
                    value="{{ old('product_code') }}"   
                    @endif 
                    name="product_code" 
                    id="product_code" 
                    placeholder="Enter Product Code"
                  >
                </div>
                <div class="form-group">
                  <label for="product_color">Product Color</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_color']))
                    value="{{ $product['product_color'] }}"
                    @else
                    value="{{ old('product_color') }}"   
                    @endif 
                    name="product_color" 
                    id="product_color" 
                    placeholder="Enter Product Color"
                  >
                </div>
                <div class="form-group">
                  <label for="product_price">Product Price</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_price']))
                    value="{{ $product['product_price'] }}"
                    @else
                    value="{{ old('product_price') }}"   
                    @endif 
                    name="product_price" 
                    id="product_price" 
                    placeholder="Enter Product Price"
                  >
                </div>
                <div class="form-group">
                  <label for="product_discount">Product Discount (%)</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_discount']))
                    value="{{ $product['product_discount'] }}"
                    @else
                    value="{{ old('product_discount') }}"    
                    @endif 
                    name="product_discount" 
                    id="product_discount" 
                    placeholder="Enter Product Discount"
                  >
                </div>
                <div class="form-group">
                  <label for="product_weight">Product Weight (g)</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['product_weight']))
                    value="{{ $product['product_weight'] }}"
                    @else
                    value="{{ old('product_weight') }}"    
                    @endif 
                    name="product_weight" 
                    id="product_weight" 
                    placeholder="Enter Product Weight"
                  >
                </div>
                <div class="form-group">
                  <label for="product_image">Product Image (Recommended Size: 1000&times;1000)</label>
                  <input 
                    type="file" 
                    class="form-control" 
                    value="{{ Auth::guard('admin')->user()->image }}" 
                    name="product_image" 
                    id="product_image"
                  >
                  @if (!empty($product['product_image']))
                    <a 
                      href="{{ url('front/images/product_images/large/'.$product['product_image']) }}"
                      target="_blank"
                    >
                      View Image
                    </a>
                    &nbsp;|&nbsp;
                    <a 
                      href="javascript:void(0)"
                      class="confirmDelete"
                      module="product-image"
                      moduleId="{{ $product['id'] }}"
                    >
                      Delete Image
                    </a>
                  @endif
                </div>
                <div class="form-group">
                  <label for="product_video">Product Video (Recommended Size: Less then 2MB)</label>
                  <input 
                    type="file" 
                    class="form-control" 
                    value="{{ Auth::guard('admin')->user()->image }}" 
                    name="product_video" 
                    id="product_video"
                  >
                  @if (!empty($product['product_video']))
                    <a 
                      href="{{ url('front/videos/product_videos/'.$product['product_video']) }}"
                      target="_blank"
                    >
                      View Video
                    </a>
                    &nbsp;|&nbsp;
                    <a 
                      href="javascript:void(0)"
                      class="confirmDelete"
                      module="product-video"
                      moduleId="{{ $product['id'] }}"
                    >
                      Delete Video
                    </a>
                  @endif
                  </div>
                <div class="form-group">
                  <label for="description">Product Description</label>
                  <textarea 
                    name="description" 
                    id="description"
                    class="form-control"
                    rows="3"
                  >
                    {{ $product['description'] }}
                  </textarea>
                </div>
               
                <div class="form-group">
                  <label for="meta_title">Meta Title</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['meta_title']))
                    value="{{ $product['meta_title'] }}{{ old('meta_title') }}"
                    @else
                    value="{{ old('meta_title') }}"    
                    @endif 
                    name="meta_title" 
                    id="meta_title" 
                    placeholder="Enter Meta Title"
                  >
                </div>
                <div class="form-group">
                  <label for="meta_description">Meta Description</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['meta_description']))
                    value="{{ $product['meta_description'] }}"
                    @else
                    value="{{ old('meta_description') }}"    
                    @endif 
                    name="meta_description" 
                    id="meta_description" 
                    placeholder="Enter Meta Description"
                  >
                </div>
                <div class="form-group">
                  <label for="meta_keywords">Meta Keywords</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($product['meta_keywords']))
                    value="{{ $product['meta_keywords'] }}"
                    @else
                    value="{{ old('meta_keywords') }}"    
                    @endif 
                    name="meta_keywords" 
                    id="meta_keywords" 
                    placeholder="Enter Meta Keywords"
                  >
                </div> 
                <div class="form-group">
                  <label for="is_featured">Featured Item</label>
                  <input 
                    type="checkbox"   
                    name="is_featured" 
                    id="is_featured" 
                    value="Yes"
                    @if (!empty($product['is_featured']) && $product['is_featured'] == 'Yes')
                      checked    
                    @endif
                  >
                </div> 
                <div class="form-group">
                  <label for="is_bestseller">Best Seller Item</label>
                  <input 
                    type="checkbox"   
                    name="is_bestseller" 
                    id="is_bestseller" 
                    value="Yes"
                    @if (!empty($product['is_bestseller']) && $product['is_bestseller'] == 'Yes')
                      checked    
                    @endif
                  >
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
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