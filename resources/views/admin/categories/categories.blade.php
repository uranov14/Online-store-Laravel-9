@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">Categories</h4>
              <a 
                href="{{ url('admin/add-edit-category') }}" 
                class="btn btn-primary btn-add"
              >
                Add Category
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
                <table id="categories" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Category Name
                      </th>
                      <th>
                        Parent Category
                      </th>
                      <th>
                        Section
                      </th>
                      <th>
                        URL
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
                    @foreach ($categories as $category)
                    @if (isset($category['parent_category']['category_name']) && !empty($category['parent_category']['category_name']))
                      @php $category['parent_category'] = $category['parent_category']['category_name'] @endphp
                    @else
                      @php $category['parent_category'] = "Root" @endphp
                    @endif
                    <tr>
                      <td>
                        {{ $category['id'] }}
                      </td>
                      <td>
                        {{ $category['category_name'] }}
                      </td>
                      <td>
                        {{ $category['parent_category'] }}
                      </td>
                      <td>
                        {{ $category['section']['name'] }}
                      </td>
                      <td>
                        {{ $category['url'] }}
                      </td>
                      <td>
                        @if ($category['status'] == 1)
                        <a 
                          class="updateCategoryStatus" 
                          id="category-{{ $category['id'] }}" 
                          category_id="{{ $category['id'] }}" 
                          href="javascript:void(0)"
                        >
                          <i class="mdi mdi-bookmark-check" status="Active"></i>
                        </a>
                        @else
                        <a 
                          class="updateCategoryStatus" 
                          id="category-{{ $category['id'] }}" 
                          category_id="{{ $category['id'] }}" 
                          href="javascript:void(0)"
                        >
                          <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                        </a>
                        @endif
                      </td>
                      <td>
                        <a href="{{ url('admin/add-edit-category/'.$category['id']) }}">
                          <i class="mdi mdi-pencil-box"></i>
                        </a>
                        {{-- <a 
                          title="Category"
                          record="category"
                          class="confirmDelete"
                          href="{{ url('admin/delete-category/'.$category['id']) }}"
                        >
                          <i class="mdi mdi-file-excel-box"></i>
                        </a> --}}
                        <a 
                          href="javascript:void(0)"
                          class="confirmDelete"
                          module="category"
                          moduleId="{{ $category['id'] }}"
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