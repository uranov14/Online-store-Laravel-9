<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsFilter;

class ProductsFiltersValue extends Model
{
    use HasFactory;

    public static function getFilterName($filter_id) {
        $filterName = ProductsFilter::select('filter_name')->where('id', $filter_id)->first();
        $filterName = json_decode(json_encode($filterName), true);
        //dd($filterName['filter_name']);
        return $filterName['filter_name'];
    }
}
