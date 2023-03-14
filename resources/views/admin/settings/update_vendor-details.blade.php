@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h4 class="card-title">Vendor Details</h4>
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
      @if ($slug == "personal")
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Personal Information</h4>

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
                action="{{ url('admin/update-vendor-details/personal') }}" 
                method="POST"
                id="updateAdminPasswordForm"
                name="updateAdminPasswordForm"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label>Vendor Username/Email</label>
                  <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                </div>
                <div class="form-group">
                  <label for="vendor_name">Name</label>
                  <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" name="vendor_name" id="vendor_name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="vendor_email">Email</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" name="vendor_email" id="vendor_email" placeholder="Current Name">
                </div>
                <div class="form-group">
                    <label for="vendor_address">Address</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['address'] }}" name="vendor_address" id="vendor_address" placeholder="Enter Address">
                </div>
                <div class="form-group">
                    <label for="vendor_city">City</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['city'] }}" name="vendor_city" id="vendor_city" placeholder="Enter City">
                </div>
                <div class="form-group">
                  <label for="vendor_state">State</label>
                  <input type="text" class="form-control" value="{{ $vendorDetails['state'] }}" name="vendor_state" id="vendor_state" placeholder="Enter State">
                </div>
                <div class="form-group">
                  <label for="vendor_country">Country</label>
                  <select 
                    class="form-control" 
                    name="vendor_country"
                    id="vendor_country"
                  >
                    <option value="" style="display: none">Select Country</option>
                    @foreach ($countries as $country)
                      <option 
                        value="{{ $country['country_name'] }}"
                        @if ($vendorDetails['country'] == $country['country_name'])
                          selected
                        @endif
                      >
                        {{ $country['country_name'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="vendor_pincode">Pincode</label>
                  <input type="text" class="form-control" value="{{ $vendorDetails['pincode'] }}" name="vendor_pincode" id="vendor_pincode" placeholder="Enter Pincode">
                </div>
                <div class="form-group">
                  <label for="vendor_mobile">Mobile Number</label>
                  <input type="text" 
                    class="form-control" 
                    value="{{ Auth::guard('admin')->user()->mobile }}" 
                    name="vendor_mobile" 
                    id="vendor_mobile" 
                    placeholder="Enter 10 Digit Mobile Number">
                </div>
                <div class="form-group">
                    <label for="vendor_image">Vendor Photo</label>
                    <input 
                      type="file" 
                      class="form-control" 
                      value="{{ Auth::guard('admin')->user()->image }}" 
                      name="vendor_image" 
                      id="vendor_image"
                    >
                    @if (!empty(Auth::guard('admin')->user()->image))
                      <a href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}" target="_blank" rel="noopener noreferrer">View Photo</a>
                      <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>    
      @elseif ($slug == "business")
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Business Information</h4>

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
                action="{{ url('admin/update-vendor-details/business') }}" 
                method="POST"
                id="updateAdminPasswordForm"
                name="updateAdminPasswordForm"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label>Vendor Username/Email</label>
                  <input 
                    class="form-control" 
                    value="{{ Auth::guard('admin')->user()->email }}" 
                    readonly
                  >
                </div>
                <div class="form-group">
                  <label for="shop_name">Shop Name</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['shop_name']))
                    value="{{ $vendorDetails['shop_name'] }}" 
                    @endif
                    name="shop_name" id="shop_name" 
                    placeholder="Enter Shop Name"
                  >
                </div>
                <div class="form-group">
                  <label for="shop_address">Shop Address</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['shop_address']))
                    value="{{ $vendorDetails['shop_address'] }}"
                    @endif 
                    name="shop_address" id="shop_address" 
                    placeholder="Enter Shop Address"
                  >
                </div>
                <div class="form-group">
                  <label for="shop_city">Shop City</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['shop_city']))
                    value="{{ $vendorDetails['shop_city'] }}"
                    @endif 
                    name="shop_city" id="shop_city" 
                    placeholder="Enter Shop City"
                  >
                </div>
                <div class="form-group">
                  <label for="shop_state">Shop State</label>
                  <input type="text" 
                    class="form-control"
                    @if (isset($vendorDetails['shop_state']))
                    value="{{ $vendorDetails['shop_state'] }}"
                    @endif  
                    name="shop_state" id="shop_state" 
                    placeholder="Enter Shop State"
                  >
                </div>
                <div class="form-group">
                  <label for="shop_country">Shop Country</label>
                  <select 
                    class="form-control" 
                    name="shop_country"
                    id="shop_country"
                  >
                    <option value="" disabled>Select Country</option>
                    @foreach ($countries as $country)
                      <option 
                        value="{{ $country['country_name'] }}"
                        @if (isset($vendorDetails['shop_country']) && $vendorDetails['shop_country'] == $country['country_name'])
                          selected
                        @endif
                      >
                        {{ $country['country_name'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="shop_pincode">Shop Pincode</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['shop_pincode']))
                    value="{{ $vendorDetails['shop_pincode'] }}"
                    @endif  
                    name="shop_pincode" id="shop_pincode" 
                    placeholder="Enter Shop Pincode"
                  >
                </div>
                <div class="form-group">
                  <label for="shop_mobile">Shop Mobile Number</label>
                  <input type="text" 
                    class="form-control"
                    @if (isset($vendorDetails['shop_mobile']))
                    value="{{ $vendorDetails['shop_mobile'] }}"
                    @endif  
                    name="shop_mobile" 
                    id="shop_mobile" 
                    placeholder="Enter 10 Digit Mobile Number">
                </div>
                <div class="form-group">
                  <label for="shop_email">Email</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['shop_email']))
                    value="{{ $vendorDetails['shop_email'] }}"
                    @endif 
                    name="shop_email" id="shop_email" 
                    placeholder="Enter Email"
                  >
                </div>
                <div class="form-group">
                  <label for="business_license_number">Business License Number</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['business_license_number']))
                    value="{{ $vendorDetails['business_license_number'] }}"
                    @endif
                    name="business_license_number" id="business_license_number" 
                    placeholder="Enter Business License Number"
                  >
                </div>
                <div class="form-group">
                  <label for="gst_number">GST Number</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['gst_number']))
                    value="{{ $vendorDetails['gst_number'] }}"
                    @endif 
                    name="gst_number" id="gst_number" 
                    placeholder="Enter GST Number"
                  >
                </div>
                <div class="form-group">
                  <label for="pan_number">PAN Number</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['pan_number']))
                    value="{{ $vendorDetails['pan_number'] }}"
                    @endif 
                    name="pan_number" id="pan_number" 
                    placeholder="Enter PAN Number"
                  >
                </div>
                <div class="form-group">
                  <label for="address_proof">Address Proof</label>
                  <select 
                    class="form-control" 
                    name="address_proof"
                    id="address_proof"
                  >
                    <option 
                      value="Passport" 
                      @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof'] == "Passport")
                        selected
                      @endif
                    >
                      Passport
                    </option>
                    <option 
                      value="Voting Card"
                      @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof'] == "Voting Card")
                        selected
                      @endif
                    >
                      Voting Card
                    </option>
                    <option 
                      value="PAN"
                      @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof'] == "PAN")
                        selected
                      @endif
                    >
                      PAN
                    </option>
                    <option 
                      value="Driving License"
                      @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof'] == "Driving License")
                        selected
                      @endif
                    >
                      Driving License
                    </option>
                    <option 
                      value="Other"
                      @if (isset($vendorDetails['address_proof']) && $vendorDetails['address_proof'] == "Other")
                        selected
                      @endif
                    >
                      Other
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="address_proof_image">Address Proof Image</label>
                  <input 
                    type="file" 
                    class="form-control" 
                    name="address_proof_image" 
                    id="address_proof_image"
                  >
                  @if (!empty($vendorDetails['address_proof_image']))
                    <a href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}" target="_blank" rel="noopener noreferrer">View Photo</a>
                    <input type="hidden" name="current_address_proof_image" value="{{ $vendorDetails['address_proof_image'] }}">
                  @endif
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @else
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Bank Information</h4>

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
                action="{{ url('admin/update-vendor-details/bank') }}" 
                method="POST"
                id="updateAdminPasswordForm"
                name="updateAdminPasswordForm"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label>Vendor Username/Email</label>
                  <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                </div>
                <div class="form-group">
                  <label for="account_holder_name">Account Holder Name</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['account_holder_name']))
                    value="{{ $vendorDetails['account_holder_name'] }}"
                    @endif 
                    name="account_holder_name" id="account_holder_name" 
                    placeholder="Enter Account Holder Name"
                  >
                </div>
                <div class="form-group">
                  <label for="account_number">Account Number</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['account_number']))
                    value="{{ $vendorDetails['account_number'] }}"
                    @endif  
                    name="account_number" id="account_number" 
                    placeholder="Enter Account Number"
                  >
                </div>
                <div class="form-group">
                  <label for="bank_name">Bank Name</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['bank_name']))
                    value="{{ $vendorDetails['bank_name'] }}"
                    @endif  
                    name="bank_name" id="bank_name" 
                    placeholder="Enter Bank Name"
                  >
                </div>
                <div class="form-group">
                  <label for="bank_ifsc_code">Bank IFSC Code</label>
                  <input type="text" 
                    class="form-control" 
                    @if (isset($vendorDetails['bank_ifsc_code']))
                    value="{{ $vendorDetails['bank_ifsc_code'] }}"
                    @endif  
                    name="bank_ifsc_code" id="bank_ifsc_code" 
                    placeholder="Enter Bank IFSC Code"
                  >
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>    
      @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection