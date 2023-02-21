@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <a href="{{ url('admin/products') }}" class="btn btn-dark font-lg">
                <h5 class="mb-1">Categories</h5>
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
                @if (empty($category['id']))
                action="{{ url('admin/add-edit-category') }}"
                @else
                action="{{ url('admin/add-edit-category/'.$category['id']) }}"    
                @endif
                method="POST"
                id="updateAdminPasswordForm"
                name="updateAdminPasswordForm"
                enctype="multipart/form-data"
              >
              @csrf
                <div class="form-group">
                  <label for="category_name">Category Name</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    @if (!empty($category['category_name']))
                    value="{{ $category['category_name'] }}"
                    @else
                    value=""    
                    @endif 
                    name="category_name" 
                    id="category_name" 
                    placeholder="Enter Category Name"
                  >
                </div>
                <div class="form-group">
                  <label for="section_id">Select Section</label>
                  <select class="form-control"  name="section_id" id="section_id">
                    <option value="" style="display: none">Select</option>
                    @foreach ($getSections as $section)
                    <option 
                      value="{{ $section['id'] }}"
                      @if (!empty($category['section_id']) && $category['section_id'] == $section['id'])
                      selected
                      @endif
                    >
                      {{ $section['name'] }}
                    </option>    
                    @endforeach
                  </select>
                </div>

                <div id="appendCategoriesLevel">
                  @include('admin.categories.append_categories_level')
                </div>
                
                <div class="form-group">
                  <label for="category_image">Category Image</label>
                  <input 
                    type="file" 
                    class="form-control" 
                    value="{{ Auth::guard('admin')->user()->image }}" 
                    name="category_image" 
                    id="category_image"
                  >
                  @if (!empty($category['category_image']))
                    <a 
                      href="{{ url('front/images/category_images/'.$category['category_image']) }}"
                      target="_blank"
                    >
                      View Image
                    </a>
                    &nbsp;|&nbsp;
                    <a 
                      href="javascript:void(0)"
                      class="confirmDelete"
                      module="category-image"
                      moduleId="{{ $category['id'] }}"
                    >
                      Delete Image
                    </a>
                  @endif
                </div>
                <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        @if (!empty($category['discount']))
                        value="{{ old($category['discount']) }}"
                        @else
                        value="{{ $category['discount'] }}"    
                        @endif 
                        name="category_discount" 
                        id="category_discount" 
                        placeholder="Enter Category Discount"
                    >
                </div>
                <div class="form-group">
                    <label for="category_discount">Category Description</label>
                    <textarea 
                        name="description" 
                        id="description"
                        class="form-control" 
                        rows="3"
                    >
                      @if (!empty($category['description']))
                      {{ $category['description'] }}  
                      @endif
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="url">Category URL</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        @if (!empty($category['url']))
                        value="{{ $category['url'] }}"
                        @else
                        value=""    
                        @endif 
                        name="url" 
                        id="url" 
                        placeholder="Enter Category URL"
                    >
                </div>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        @if (!empty($category['meta_title']))
                        value="{{ old($category['meta_title']) }}"
                        @else
                        value="{{ $category['meta_title'] }}"    
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
                        @if (!empty($category['meta_description']))
                        value="{{ old($category['meta_description']) }}"
                        @else
                        value="{{ $category['meta_description'] }}"    
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
                        @if (!empty($category['meta_keywords']))
                        value="{{ old($category['meta_keywords']) }}"
                        @else
                        value="{{ $category['meta_keywords'] }}"    
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