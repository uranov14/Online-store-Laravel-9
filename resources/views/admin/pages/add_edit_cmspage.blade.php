@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <a href="{{ url('admin/cms-pages') }}">
                <h4 style="text-decoration: underline;">CMS Pages</h4>
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
                @if (empty($cmspage['id']))
                action="{{ url('admin/add-edit-cms-page') }}"
                @else
                action="{{ url('admin/add-edit-cms-page/'.$cmspage['id']) }}"    
                @endif
                method="POST"
                id="updateCmsPageForm"
                name="updateCmsPageForm"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label for="title">Title</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($cmspage['title']))
                    value="{{ $cmspage['title'] }}"
                    @else
                    value="{{ old('title') }}"    
                    @endif 
                    name="title" 
                    id="title" 
                    placeholder="Enter Title"
                  >
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea 
                        name="description" 
                        id="description"
                        class="form-control" 
                        rows="3"
                    >
                      @if (!empty($cmspage['description']))
                      {{ $cmspage['description'] }}  
                      @endif
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="url">Page URL</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        @if (!empty($cmspage['url']))
                        value="{{ $cmspage['url'] }}"
                        @else
                        value="{{ old('url') }}"    
                        @endif 
                        name="url" 
                        id="url" 
                        placeholder="Enter URL"
                    >
                </div>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        @if (!empty($cmspage['meta_title']))
                        value="{{ $cmspage['meta_title'] }}"
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
                        @if (!empty($cmspage['meta_description']))
                        value="{{ $cmspage['meta_description'] }}"
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
                        @if (empty($cmspage['meta_keywords']))
                        value="{{ old('meta_keywords') }}"
                        @else
                        value="{{ $cmspage['meta_keywords'] }}"    
                        @endif 
                        name="meta_keywords" 
                        id="meta_keywords" 
                        placeholder="Enter Meta Keywords"
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