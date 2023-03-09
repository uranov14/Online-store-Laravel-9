@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        {{-- <a href="{{ url('admin/products') }}" class="btn btn-dark">
                            <h5 class="font-weight-normal mb-1">
                                Back to Products
                            </h5>
                        </a> --}}
                        <h4 class="font-weight-bold">
                            Vendor Details
                        </h4>
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
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Personal Information</h4>
                        <div class="form-group">
                            <label>Vendor Email</label>
                            <input class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_name">Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['name'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_address">Address</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['address'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_city">City</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['city'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_state">State</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['state'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_country">Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['country'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_pincode">Pincode</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['pincode'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vendor_mobile">Mobile Number</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['mobile'] }}" readonly>
                        </div>
                        @if (!empty($vendorDetails['image']))
                        <div class="form-group">
                            <label for="vendor_image">Vendor Photo</label>
                            <br>
                            <img style="width: 200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"/>                   
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Business Information</h4>
                        <div class="form-group">
                            <label for="shop_name">Shop Name</label>
                            <input 
                                type="text" 
                                name="shop_name" 
                                class="form-control" 
                                @if (empty($vendorDetails['vendor_business']))
                                    value=""
                                @else
                                    value="{{ $vendorDetails['vendor_business']['shop_name'] }}"
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_address">Shop Address</label>
                            <input 
                                type="text" 
                                name="shop_address"
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_address'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_city">Shop City</label>
                            <input 
                                type="text"
                                name="shop_city" 
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_city'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_state">Shop State</label>
                            <input 
                                type="text"
                                name="shop_state" 
                                class="form-control"
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_state'] }}"
                                @else
                                    value=""
                                @endif  
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_country">Shop Country</label>
                            <input 
                                type="text"
                                name="shop_country"  
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_country'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_pincode">Shop Pincode</label>
                            <input 
                                type="text" 
                                name="shop_pincode"
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_mobile">Shop Mobile</label>
                            <input 
                                type="text" 
                                name="shop_mobile"
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="shop_website">Shop Website</label>
                            <input 
                                type="text"
                                name="shop_website" 
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_website'] }}"
                                @else
                                    value=""
                                @endif  
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label>Shop Email</label>
                            <input 
                                class="form-control" 
                                name="shop_email"
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['shop_email'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label>Address Proof</label>
                            <input 
                                class="form-control" 
                                name="address_proof"
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['address_proof'] }}"
                                @else
                                    value=""
                                @endif 
                                readonly
                            >
                        </div>
                        @if (!empty($vendorDetails['vendor_business']['address_proof_image']))
                        <div class="form-group">
                            <label for="address_proof_image">Address Proof Image</label>
                            <br>
                            <img style="width: 200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}"/>                   
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Business License</label>
                            <input 
                                class="form-control"
                                name="business_license_number" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['business_license_number'] }}"
                                @else
                                    value=""
                                @endif
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label>GST Number</label>
                            <input 
                                name="gst_number"
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['gst_number'] }}"
                                @else
                                    value=""
                                @endif
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label>PAN Number</label>
                            <input 
                                name="pan_number"
                                class="form-control" 
                                @if (!empty($vendorDetails['vendor_business']))
                                    value="{{ $vendorDetails['vendor_business']['pan_number'] }}"
                                @else
                                    value=""
                                @endif
                                readonly
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bank Information</h4>
                        <div class="form-group">
                            <label>Account Holder Name</label>
                            <input class="form-control" 
                                @if (isset($vendorDetails['vendor_bank']['account_holder_name']))
                                value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" 
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="vendor_address">Account Numder</label>
                            <input type="text" 
                                class="form-control" 
                                @if (isset($vendorDetails['vendor_bank']['account_number']))
                                value="{{ $vendorDetails['vendor_bank']['account_number'] }}" 
                                @endif 
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="vendor_name">Bank Name</label>
                            <input type="text" 
                                class="form-control" 
                                @if (isset($vendorDetails['vendor_bank']['bank_name']))
                                value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" 
                                @endif
                                readonly
                            >
                        </div>
                        <div class="form-group">
                            <label for="vendor_city">Bank IFSC Code</label>
                            <input type="text" 
                                class="form-control" 
                                @if (isset($vendorDetails['vendor_bank']['bank_ifsc_code']))
                                value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}" 
                                @endif 
                                readonly
                            >
                        </div>
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