<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;
use Session;
use Auth;
use Image;

class ProductsController extends Controller
{
    public function products() {
        Session::put('page', "products");
        $products = Product::with(['section', 'category'])->get()->toArray();
        //dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 1) {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update products table
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function addEditProduct(Request $request, $id = null) {
        Session::put('page', 'products');
        if ($id == null) {
            $title = "Add Product";
            $product = new Product;
            $message = "added successfully";
        } else {
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "updated successfully";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            if(empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            }
            if(empty($data['product_weight'])) {
                $data['product_weight'] = 0;
            }
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/(\w+-*\s*)+/u',
                'product_code' => 'required|regex:/^\w+$/u',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessage =[
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
            ];

            $this->validate($request, $rules, $customMessage);

            //Upload Product Image after Resize - small: 250x250, medium: 500x500, large: 1000x1000
            if($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);
                    //Insert Image Name in products table
                    $product->product_image = $imageName;
                }
            }else if(!empty($data['current_product_image'])) {
                $imageName = $data['current_product_image'];
            }else {
                $imageName = '';
            }

            //Upload Product Video
            if($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    //Get video extension
                    $extension = $video_tmp->getClientOriginalExtension();
                    //Generate New Video Name
                    $videoName= rand(111, 99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';

                    $video_tmp->move($videoPath, $videoName);

                    //Insert Video in products table
                    $product->product_video = $videoName;
                }
            }

            //Save Product Details in products table
            $categoryDetails = Category::find($data['category_id']);
            //dd($categoryDetails);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $filter) {
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $data['category_id']);

                if ($filterAvailable == 'Yes' 
                && isset($filter['filter_column']) 
                && $data[$filter['filter_column']]) {
                    $product->{ $filter['filter_column'] } = $data[$filter['filter_column']];
                }
            }

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }
            
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->status = 1;

            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }

            if (!empty($data['is_bestseller'])) {
                $product->is_bestseller = $data['is_bestseller'];
            } else {
                $product->is_bestseller = "No";
            }

            $product->save();

            return redirect('admin/products')->with('success_message', "Product ".$data['product_name']." ".$message);
        }
        
        //Get Sections with Categories and SubCategories
        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);

        //Get All Brands
        $brands = Brand::where('status', 1)->get()->toArray();
        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'brands', 'product'));
    }

    public function deleteProduct($id) {
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteProductImage($id) {
        //Get Product Image
        $productImage = Product::select('product_image')->where('id', $id)->first();
        //Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
        //Delete Product Image from product_images folder if exists
        if (file_exists($small_image_path.$productImage->product_image)) {
            unlink($small_image_path.$productImage->product_image);
        }
        if (file_exists($medium_image_path.$productImage->product_image)) {
            unlink($medium_image_path.$productImage->product_image);
        }
        if (file_exists($large_image_path.$productImage->product_image)) {
            unlink($large_image_path.$productImage->product_image);
        }
        //Delete Product Image from products table DB
        Product::where('id', $id)->update(['product_image'=>'']);
        $message = "Product Image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteProductVideo($id) {
        //Get Product Video
        $productVideo = Product::select('product_video')->where('id', $id)->first();
        //Get Product Video Paths
        $product_video_path = 'front/videos/product_videos/';
        //Delete Product Video from product_videos folder if exists
        if (file_exists($product_video_path.$productVideo->product_video)) {
            unlink($product_video_path.$productVideo->product_video);
        }
        //Delete Product Video from products table DB
        Product::where('id', $id)->update(['product_video'=>'']);
        $message = "Product Video has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function addAttributes(Request $request, $id) {
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name','product_code', 'product_color', 'product_price', 'product_image')->with('attributes')->find($id);
        /* $product = json_decode(json_encode($product), true);
        dd($product); */
        if ($request->isMethod('post')) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    //Check duplicate SKU
                    $skuCount = ProductsAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', "SKU already exists! Please add another SKU!");
                    }
                    //Check duplicate Size
                    $sizeCount = ProductsAttribute::where('size', $data['size'][$key])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', "Size already exists! Please add another Size!");
                    }

                    //Save Attributes in products_attributes table
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message', "Product Attributes has been added successfully");
        }
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributeStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update Products Attribute table
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function editAttributes(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach ($data['attributeId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductsAttribute::where('id', $data['attributeId'][$key])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message', "Product Attributes has been updated successfully");
        }
    }

    public function addImages(Request $request, $id) {
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name','product_code', 'product_color', 'product_price', 'product_image')->with('images')->find($id);
        /* $product = json_decode(json_encode($product), true);
        dd($product); */
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    if ($image->isValid()) {
                        //Generate Temp Image
                        $image_tmp = Image::make($image);
                        //Get Image Name
                        $image_name = $image->getClientOriginalName();
                        //Get image extension
                        $extension = $image->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName= $image_name.rand(111, 99999).'.'.$extension;
                        
                        $largeImagePath = 'front/images/product_images/large/'.$imageName;
                        $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                        $smallImagePath = 'front/images/product_images/small/'.$imageName;
                        //Upload the Image
                        Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                        Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                        Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);
                        //Insert Image Name in products table
                        $image = new ProductsImage;
                        $image->image = $imageName;
                        $image->product_id = $id;
                        $image->status = 1;
                        $image->save();
                    }
                }
            }
            return redirect()->back()->with('success_message', "Product Images has been added successfully");
        }
        return view('admin.images.add_images')->with(compact('product'));
    }

    public function updateImageStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update Products Attribute table
            ProductsImage::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id) {
        //Get Product Image
        $productImage = ProductsImage::select('image')->where('id', $id)->first();
        //Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
        //Delete Product Image from product_images folder if exists
        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }
        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }
        //Delete Product Image from products_image table DB
        ProductsImage::where('id', $id)->delete();
        $message = "Product Image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }
}
