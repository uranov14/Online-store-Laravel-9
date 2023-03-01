@php
    use App\Models\ProductsFilter;
@endphp

@extends('admin.layouts.layout')

@section('content')
<div class="main-panel">
    <a 
        href="{{ url('admin/filters') }}" 
        class="btn btn-dark btn-back"
    >
        Back to Filters
    </a>
    
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title font-weight-bold">Filters Values</h4>
              <a 
                href="{{ url('admin/add-edit-filter-value') }}" 
                class="btn btn-primary btn-add"
              >
                Add Filter Values
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
                <table id="filter_values" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        ID
                      </th>
                      <th>
                        Filter ID
                      </th>
                      <th>
                        Filter Name
                      </th>
                      <th>
                        Filter Value
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
                    @foreach ($filtersValues as $filter)
                    <tr>
                      <td>
                          {{ $filter['id'] }}
                      </td>
                      <td>
                        {{ $filter['filter_id'] }}
                      </td>
                        <td>
                          @php
                            $filterName = ProductsFilter::getFilterName($filter['filter_id']);
                            echo $filterName;
                          @endphp 
                        </td>
                        <td>
                          {{ $filter['filter_value'] }}
                        </td>
                        <td>
                          @if ($filter['status'] == 1)
                          <a 
                            class="updateFilterValueStatus" 
                            id="filter-{{ $filter['id'] }}" 
                            filter_id="{{ $filter['id'] }}" 
                            href="javascript:void(0)"
                          >
                            <i class="mdi mdi-bookmark-check" status="Active"></i>
                          </a>
                          @else
                          <a 
                            class="updateFilterValueStatus" 
                            id="filter-{{ $filter['id'] }}" 
                            filter_id="{{ $filter['id'] }}" 
                            href="javascript:void(0)"
                          >
                            <i class="mdi mdi-bookmark-outline" status="Inactive"></i>
                          </a>
                          @endif
                        </td>
                        <td>
                          <a href="{{ url('admin/add-edit-filter-value/'.$filter['id']) }}">
                            <i class="mdi mdi-pencil-box"></i>
                          </a>
                          {{-- <a 
                            title="Brand"
                            record="filter-value"
                            class="confirmDelete"
                            href="{{ url('admin/delete-filter-value/'.$filter-value['id']) }}"
                          >
                            <i class="mdi mdi-file-excel-box"></i>
                          </a> --}}
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
    @include('admin.layouts.footer')
    <!-- partial -->
  </div>
@endsection