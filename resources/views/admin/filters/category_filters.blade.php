<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
//dd($productFilters);
if (isset($product['category_id'])) {
  $category_id = $product['category_id'];
}

?>

@foreach ($productFilters as $filter)
  @if (isset($category_id))
  @php
    $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $category_id);
  @endphp
    @if ($filterAvailable == 'Yes')
      <div class="form-group">
        <label for="{{ $filter['filter_column'] }}">Select {{ $filter['filter_name'] }}</label>
        <select class="form-control text-dark"  name="{{ $filter['filter_column'] }}" id="{{ $filter['filter_column'] }}">
          <option value="" style="display: none">
            Select
          </option>
          @foreach ($filter['filter_values'] as $value)
            <option 
              value="{{ $value['filter_value'] }}" 
              @if (!empty($filter['filter_column']))
                selected
              @endif
            >
              {{ $value['filter_value'] }}
            </option>
          @endforeach
        </select>
      </div>
    @endif  
  @endif
@endforeach