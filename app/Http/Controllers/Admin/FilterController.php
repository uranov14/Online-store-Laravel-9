<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use App\Models\Section;
use Session;
use DB;

class FilterController extends Controller
{
    public function filters() {
        Session::put('page', "filters");
        $filters = ProductsFilter::get()->toArray();
        //dd($filters);
        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues() {
        Session::put('page', "filters_values");
        $filtersValues = ProductsFiltersValue::get()->toArray();
        //dd($filters);
        return view('admin.filters.filters_values')->with(compact('filtersValues'));
    }

    public function updateFilterStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update products_filters table
            ProductsFilter::where('id', $data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'filter_id'=>$data['filter_id']]);
        }
    }

    public function updateFilterValueStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update products_filters_values table
            ProductsFiltersValue::where('id', $data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'filter_id'=>$data['filter_id']]);
        }
    }

    public function addEditFilter(Request $request, $id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Add Filter";
            $filter = new ProductsFilter;
            $message = "Filter added successfully";
        }else{
            $title = "Edit Filter";
            $filter = ProductsFilter::find($id);
            $message = "Filter updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $cat_ids = implode(',',$data['cat_ids']);

            // Save Filter column details in products_filters table
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            // Add filter column in products table
            DB::statement('Alter table products DROP IF EXISTS '.$data['filter_column']);
            DB::statement('Alter table products add '.$data['filter_column'].' varchar(255) after description');

            return redirect('admin/filters')->with('success_message', $message);
        }

        // Get Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();

        return view('admin.filters.add_edit_filter')->with(compact('title','categories','filter'));
    }

    public function addEditFilterValue(Request $request,$id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Add Filter Value";
            $filterValue = new ProductsFiltersValue;
            $message = "Filter Value added successfully";
        }else{
            $title = "Edit Filter Value";
            $filterValue = ProductsFiltersValue::find($id);
            $message = "Filter Value updated successfully";
        }
        //dd($filterValue);
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            // Save Filter value details in products_filters_values table
            $filterValue->filter_id = $data['filter_id'];
            $filterValue->filter_value = $data['filter_value'];
            $filterValue->status = 1;
            $filterValue->save();

            return redirect('admin/filters-values')->with('success_message', $message);
        }

        // Get Filters
        $filters = ProductsFilter::where('status', 1)->get()->toArray();

        return view('admin.filters.add_edit_filter_value')->with(compact('title', 'filterValue', 'filters'));
    }

    public function categoryFilters(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            echo "<pre>"; print_r($data); die; 
            $category_id = $data['category_id']; 

            return response()->json(['view'=>(String)View::make('admin.filters.category_filters')->with(compact('category_id'))]);        
        }
    }
}
