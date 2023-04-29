@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">CMS Pages</h4>
              <a 
                href="{{ url('admin/add-edit-cms-page') }}" 
                class="btn btn-primary btn-add"
              >
                Add Page
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
                <table id="pages" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Title
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
                    @foreach ($cmspages as $page)
                    <tr>
                        <td>
                          {{ $page['id'] }}
                        </td>
                        <td>
                          {{ $page['title'] }}
                        </td>
                        <td>
                          {{ $page['url'] }}
                        </td>
                        <td>
                          @if ($page['status'] == 1)
                            <a 
                              class="updatePageStatus" 
                              id="page-{{ $page['id'] }}" 
                              page_id="{{ $page['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-check" status="Active"></i>
                            </a>
                          @else
                            <a 
                              class="updatePageStatus" 
                              id="page-{{ $page['id'] }}" 
                              page_id="{{ $page['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                            </a>
                          @endif
                        </td>
                        <td>
                          <a href="{{ url('admin/add-edit-cms-page/'.$page['id']) }}">
                            <i class="mdi mdi-pencil-box"></i>
                          </a>
                          <a 
                            href="javascript:void(0)"
                            class="confirmDelete"
                            module="page"
                            moduleId="{{ $page['id'] }}"
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