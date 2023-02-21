@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">Products</h4>
              <a 
                href="{{ url('admin/add-edit-product') }}" 
                class="btn btn-primary btn-add"
              >
                Add Product
              </a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong>{{ Session::get('success_message') }}
                <button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="table-responsive pt-3">
                <table id="products" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Product Name
                      </th>
                      <th>
                        Product Code
                      </th>
                      <th>
                        Product Color
                      </th>
                      <th>
                        Product Image
                      </th>
                      <th>
                        Category
                      </th>
                      <th>
                        Section
                      </th>
                      <th>
                        Added by
                      </th>
                      <th>
                        Discount
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                    <tr>
                      <td>
                        {{ $product['id'] }}
                      </td>
                      <td>
                        {{ $product['product_name'] }}
                      </td>
                      <td>
                        {{ $product['product_code'] }}
                      </td>
                      <td>
                        {{ $product['product_color'] }}
                      </td>
                      <td>
                        @if (!empty($product['product_image']))
                          <img style="width: 120px; height:120px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" alt="">
                        @else
                          <img style="width: 120px; height:120px;" src="{{ asset('front/images/product_images/small/no-image.webp') }}" alt="">
                        @endif
                      </td>
                      <td>
                        {{ $product['category']['category_name'] }}
                      </td>
                      <td>
                        {{ $product['section']['name'] }}
                      </td>
                      <td>
                        @if ($product['admin_type'] == 'vendor')
                        <a target="_blank" href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">
                          {{ ucfirst($product['admin_type']) }}
                        </a>
                        @else
                          {{ ucfirst($product['admin_type']) }}
                        @endif
                      </td>
                      <td>
                        {{ $product['product_discount'] }}
                      </td>
                      <td>
                        @if ($product['status'] == 1)
                        <a 
                          class="updateProductStatus" 
                          name="product-{{ $product['id'] }}"
                          id="product-{{ $product['id'] }}" 
                          product_id="{{ $product['id'] }}" 
                          href="javascript:void(0)"
                        >
                          <i class="mdi mdi-bookmark-check" status=1></i>
                        </a>
                        @else
                        <a 
                          class="updateProductStatus" 
                          name="product-{{ $product['id'] }}" 
                          id="product-{{ $product['id'] }}"
                          product_id="{{ $product['id'] }}" 
                          href="javascript:void(0)"
                        >
                          <i class="mdi mdi-bookmark-outline" status=0></i>
                        </a>
                        @endif
                      </td>
                      <td>
                        <div>
                          <a title="Edit product details" href="{{ url('admin/add-edit-product/'.$product['id']) }}">
                            <i class="mdi mdi-pencil-box"></i>
                          </a>
                        </div>
                        <div>
                          <a title="Add attributes" href="{{ url('admin/add-attributes/'.$product['id']) }}">
                            <i class="mdi mdi-plus-box"></i>
                          </a>
                        </div>
                        <div>
                          <a title="Add altenative images" href="{{ url('admin/add-images/'.$product['id']) }}">
                            <i class="mdi mdi-image-multiple"></i>
                          </a>
                        </div>
                        <div>
                          <a 
                            title="Delete"
                            href="javascript:void(0)"
                            class="confirmDelete"
                            module="product"
                            moduleId="{{ $product['id'] }}"
                          >
                            <i class="mdi mdi-file-excel-box"></i>
                          </a>
                        </div>
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
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection