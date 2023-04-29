@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">
                Shipping Charges
              </h4>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong>{{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="table-responsive pt-3">
                <table id="shipping" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Country</th>
                      <th>Rate (0g to 500g)</th>
                      <th>Rate (501g to 1000g)</th>
                      <th>Rate (1001g to 2000g)</th>
                      <th>Rate (2001g to 5000g)</th>
                      <th>Rate (above 5000g)</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($shippingCharges as $shipping)
                      <tr>
                        <td>
                          {{ $shipping['id'] }}
                        </td>
                        <td>
                          {{ $shipping['country'] }}
                        </td>
                        <td>
                          {{ $shipping['0_500g'] }}
                        </td>
                        <td>
                          {{ $shipping['501_1000g'] }}
                        </td>
                        <td>
                          {{ $shipping['1001_2000g'] }}
                        </td>
                        <td>
                          {{ $shipping['2001_5000g'] }}
                        </td>
                        <td>
                          {{ $shipping['above_5000g'] }}
                        </td>
                        <td>
                          @if ($shipping['status'] == 1)
                            <a 
                              class="updateShippingStatus" 
                              id="shipping-{{ $shipping['id'] }}" 
                              shipping_id="{{ $shipping['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-check" status="Active"></i>
                            </a>
                            @else
                            <a 
                              class="updateShippingStatus" 
                              id="shipping-{{ $shipping['id'] }}" 
                              shipping_id="{{ $shipping['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-shipping/'.$shipping['id']) }}">
                              <i class="mdi mdi-pencil-box"></i>
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
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection