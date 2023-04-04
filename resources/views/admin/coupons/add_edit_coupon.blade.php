@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <a href="{{ url('admin/coupons') }}" class="btn btn-dark">
                Back to Coupons
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
                @if (empty($coupon['id']))
                action="{{ url('admin/add-edit-coupon') }}"
                @else
                action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"    
                @endif
                method="post"
                enctype="multipart/form-data"
              >
              @csrf
              @if (empty($coupon['coupon_code']))
                <div class="form-group">
                  <label for="coupon_option">Coupon Option</label>
                  <br>
                  <input 
                    type="radio"  
                    value="Automatic"
                    name="coupon_option" 
                    id="AutomaticCoupon" 
                    checked
                  >
                  &nbsp;Automatic  
                  <br>                
                  <input 
                    type="radio"  
                    value="Manual"
                    name="coupon_option" 
                    id="ManualCoupon" 
                  >
                  &nbsp;Manual
                </div>
                <div class="form-group" style="display: none;" id="couponField">
                  <label for="coupon_code">Coupon Code</label>
                  <input 
                    type="radio" 
                    class="form-control" 
                    name="coupon_code" 
                    id="product_code"
                    placeholder="Enter Coupon Code"
                  >
                </div>  
              @else
                <input 
                  type="hidden"  
                  value="{{ $coupon['coupon_option'] }}"
                  name="coupon_option" 
                >
                <input 
                  type="hidden"  
                  value="{{ $coupon['coupon_code'] }}"
                  name="coupon_code" 
                >
                <div class="form-group">
                  <h6>
                    Coupon Code:
                    <span>{{ $coupon['coupon_code'] }}</span>
                  </h6>
                </div>
              @endif
                <div class="form-group">
                  <label for="coupon_type">Coupon Type</label>
                  <br>
                  <input 
                    type="radio"  
                    value="Multiple Times"
                    name="coupon_type" 
                    @if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Multiple Times")
                      checked
                    @endif 
                  >
                  &nbsp;Multiple Times 
                  <br>                
                  <input 
                    type="radio"  
                    value="Single Time"
                    name="coupon_type"
                    @if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Single Time")
                      checked
                    @endif 
                  >
                  &nbsp;Single Time
                </div>
                <div class="form-group">
                  <label for="amount_type">Amount Type</label>
                  <br>
                  <input 
                    type="radio"  
                    value="Percentage"
                    name="amount_type" 
                    @if (isset($coupon['amount_type']) && $coupon['amount_type'] == "Percentage")
                      checked
                    @endif
                  >
                  &nbsp;Percentage (%)
                  <br>                
                  <input 
                    type="radio"  
                    value="Fixed"
                    name="amount_type"
                    @if (isset($coupon['amount_type']) && $coupon['amount_type'] == "Fixed")
                      checked
                    @endif
                  >
                  &nbsp;Fixed (&#x20b4; or $)
                </div>
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    name="amount" 
                    id="amount" 
                    placeholder="Enter Amount"
                    @if (isset($coupon['amount']))
                      value="{{ $coupon['amount'] }}"
                    @else
                      value="{{ old('amount') }}"
                    @endif
                  >
                </div>
                <div class="form-group">
                  <label for="categories">Select Category</label>
                  <select class="form-control text-dark"  name="categories[]" multiple>
                   
                    @foreach ($categories as $section)
                      <optgroup label="{{ $section['name'] }}"></optgroup>
                      @foreach ($section['categories'] as $category)
                        <option 
                          @if (in_array($category['id'], $selectCats))
                            selected
                          @endif 
                          value="{{ $category['id'] }}"
                        >
                          &nbsp;&nbsp;-&nbsp;{{ $category['category_name'] }}
                        </option>
                        @foreach ($category['sub_categories'] as $subcategory)
                          <option 
                          @if (in_array($subcategory['id'], $selectCats))
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
                <div class="form-group">
                  <label for="brands">Select Brand</label>
                  <select class="form-control text-dark"  name="brands[]" id="brands" multiple>
                    @foreach ($brands as $brand)
                      <option 
                      @if (in_array($brand['id'], $selectBrands))
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
                  <label for="users">Select Users</label>
                  <select class="form-control text-dark"  name="users[]" multiple>
                    @foreach ($users as $user)
                      <option 
                        @if (in_array($user['email'], $selectUsers))
                          selected
                        @endif
                        value="{{ $user['email'] }}"
                      >
                        {{ $user['email'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="expiry_date">Expiry Date</label>
                  <input 
                    type="date" 
                    class="form-control" 
                    name="expiry_date" 
                    id="expiry_date" 
                    placeholder="Enter Expiry Date"
                    @if (isset($coupon['expiry_date']))
                      value="{{ $coupon['expiry_date'] }}"
                    @else
                      value="{{ old('expiry_date') }}"
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