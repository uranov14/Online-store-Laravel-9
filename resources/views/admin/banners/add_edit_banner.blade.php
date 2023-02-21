@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h4 class="card-title">Home Page Banners</h4>
              <a href="{{ url('admin/banners') }}" class="btn btn-dark">Back to Banners</a>
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
                @if (empty($banner['id']))
                action="{{ url('admin/add-edit-banner') }}"
                @else
                action="{{ url('admin/add-edit-banner/'.$banner['id']) }}"    
                @endif
                method="POST"
                id="updateBanner"
                name="updateBanner"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                    <label for="type">Banner Type</label>
                    <select name="type" class="form-control text-dark" required>
                        <option value="" style="display: none;">Select</option>
                        <option @if (!empty($banner['type']) && $banner['type'] == 'Slider')
                            selected
                        @endif value="Slider">Slider</option>
                        <option @if (!empty($banner['type']) && $banner['type'] == 'Fix')
                            selected
                        @endif value="Fix">Fix</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="image">Banner Image</label>
                  <input 
                    type="file" 
                    class="form-control"  
                    name="image" 
                    id="image"
                  >
                  @if (!empty($banner['image']))
                    <a 
                      href="{{ url('front/images/banners/'.$banner['image']) }}"
                      target="_blank"
                    >
                      View Image
                    </a>
                  @endif
                </div>
                <div class="form-group">
                    <label for="title">Banner Title</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      @if (!empty($banner['title']))
                      value="{{ $banner['title'] }}"
                      @else
                      value="{{ old('title') }}"    
                      @endif 
                      name="title" 
                      id="title" 
                      placeholder="Enter Banner Title"
                    >
                </div>
                <div class="form-group">
                    <label for="link">Banner Link</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      @if (!empty($banner['link']))
                      value="{{ $banner['link'] }}"
                      @else
                      value="{{ old('link') }}"    
                      @endif 
                      name="link" 
                      id="link" 
                      placeholder="Enter Banner Link"
                    >
                </div>
                <div class="form-group">
                    <label for="alt">Banner Alternate Text</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      @if (!empty($banner['alt']))
                      value="{{ $banner['alt'] }}"
                      @else
                      value="{{ old('alt') }}"    
                      @endif 
                      name="alt" 
                      id="alt" 
                      placeholder="Enter Banner Alternate Text"
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