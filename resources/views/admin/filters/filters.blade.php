@extends('admin.layout.layout')
@php
  use App\Models\Category;
@endphp
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">Filters</h4>
              <a 
                href="{{ url('admin/add-edit-filter') }}" 
                class="btn btn-primary btn-add"
              >
                Add Filter
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
                <table id="brands" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Filter Name
                      </th>
                      <th>
                        Filter Column
                      </th>
                      <th>
                        Categories
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
                    @foreach ($filters as $filter)
                      <tr>
                        <td>
                          {{ $filter['id'] }}
                        </td>
                        <td>
                          {{ $filter['filter_name'] }}
                        </td>
                        <td>
                          {{ $filter['filter_column'] }}
                        </td>
                        <td>
                          @php
                            //Split String to Array
                            $arrCatIds = explode(",", $filter['cat_ids']);
                            foreach ($arrCatIds as $key => $catId) {
                              $categoryName = Category::getCategoryName($catId);
                              echo $categoryName."<br>";
                            }
                          @endphp
                        </td>
                        <td>
                          @if ($filter['status'] == 1)
                            <a 
                              class="updateFilterStatus" 
                              id="filter-{{ $filter['id'] }}" 
                              filter_id="{{ $filter['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-check" status="Active"></i>
                            </a>
                          @else
                            <a 
                              class="updateFilterStatus" 
                              id="filter-{{ $filter['id'] }}" 
                              filter_id="{{ $filter['id'] }}" 
                              href="javascript:void(0)"
                            >
                              <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                            </a>
                          @endif
                        </td>
                        <td>
                          <a href="{{ url('admin/add-edit-filter-value') }}">
                            <i class="mdi mdi-pencil-box"></i>
                          </a>
                          <a title="Add filter values" href="{{ url('admin/add-edit-filter-value') }}">
                            <i class="mdi mdi-plus-box"></i>
                          </a>
                          <a 
                            href="javascript:void(0)"
                            class="confirmDelete"
                            module="filter"
                            moduleId="{{ $filter['id'] }}"
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
    <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
      </div>
    </footer>
    <!-- partial -->
  </div>
@endsection