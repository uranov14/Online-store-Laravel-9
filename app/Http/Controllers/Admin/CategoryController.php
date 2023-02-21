<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page', "categories");
        $categories = Category::with(['section', 'parentCategory'])->get()->toArray();
        //dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update sections table
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null) {
        Session::put('page', 'categories');
        if ($id == null) {
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "added successfully";
        } else {
            $title = "Edit Category";
            $category = Category::find($id);
            //echo "<pre>"; print_r($category); die;
            $getCategories = Category::with('subCategories')->where(['parent_id'=>0, 'section_id'=>$category['section_id']])->get();
            $message = "Category updated successfully";
        }
        //echo "<pre>"; print_r($getCategories); die;

        //Get All Sections
        $getSections = Section::get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
                'section_id' => 'required',
            ];

            $customMessage =[
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid Category Name is required',
                'section_id.required' => 'Section is required',
                'url.required' => 'Category URL is required',
            ];

            $this->validate($request, $rules, $customMessage);
            
            //Upload Category Image
            if($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $imagePath = 'front/images/category_images/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            }else {
                $category->category_image = '';
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message', "Category ".$data['category_name']." ".$message);
        }
        //echo "<pre>"; print_r($getCategories); die;

        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSections', 'getCategories'));
    }

    public function appendCategoryLevel(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            $getCategories = Category::with('subCategories')->where(['parent_id'=>0, 'section_id'=>$data['section_id']])->get()->toArray();
            //echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
    
    public function deleteCategory($id) {
        
        Category::where('id', $id)->delete();
        $message = "Category has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }
    
    public function deleteCategoryImage($id) {
        //Get Category Image
        $categoryImage = Category::select('category_image')->where('id', $id)->first();
        //Get Category Image Path
        $category_image_path = 'front/images/category_images/';
        //Delete Category Image from category_images folder if exists
        if (file_exists($category_image_path.$categoryImage->category_image)) {
            unlink($category_image_path.$categoryImage->category_image);
        }
        //Delete Category Image from categories table DB
        Category::where('id', $id)->update(['category_image'=>'']);
        $message = "Category Image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }
}
