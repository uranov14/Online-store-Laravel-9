@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">Coupons</h4>
              <a 
                href="{{ url('admin/add-edit-coupon') }}" 
                class="btn btn-primary btn-add"
              >
                Add Coupon
              </a>
              @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong>{{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="table-responsive pt-3">
                <table id="coupons" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Coupon Code
                      </th>
                      <th>
                        Coupon Type
                      </th>
                      <th>
                        Amount
                      </th>
                      <th>
                        Expiry Date
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
                    @foreach ($coupons as $coupon)
                    <tr>
                        <td>
                          {{ $coupon['id'] }}
                        </td>
                        <td>
                          {{ $coupon['coupon_code'] }}
                        </td>
                        <td>
                          {{ $coupon['coupon_type'] }}
                        </td>
                        <td>
                          {{ $coupon['amount'] }}
                          @if ($coupon['amount_type'] == 'Percentage')
                            %
                          @else
                            &#x20b4;
                          @endif
                        </td>
                        <td>
                          {{ $coupon['expiry_date'] }}
                        </td>
                        <td>
                            @if ($coupon['status'] == 1)
                            <a 
                              class="updateCouponStatus" 
                              id="coupon-{{ $coupon['id'] }}" 
                              coupon_id="{{ $coupon['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-check" status="Active"></i>
                            </a>
                            @else
                            <a 
                              class="updateCouponStatus" 
                              id="coupon-{{ $coupon['id'] }}" 
                              coupon_id="{{ $coupon['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}">
                              <i class="mdi mdi-pencil-box"></i>
                            </a>
                            {{-- <a 
                              title="Coupon"
                              record="coupon"
                              class="confirmDelete"
                              href="{{ url('admin/delete-coupon/'.$coupon['id']) }}"
                            >
                              <i class="mdi mdi-file-excel-box"></i>
                            </a> --}}
                            <a 
                              href="javascript:void(0)"
                              class="confirmDelete"
                              module="coupon"
                              moduleId="{{ $coupon['id'] }}"
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
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection