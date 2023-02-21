<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners() {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
        //dd($banners);
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if ($data['status'] == "Active") {
                $status = 0;
            }else {
                $status = 1;
            }
            //Update banners table
            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id) {
        //Get Banner Image
        $bannerImage = Banner::where('id', $id)->first();
        //Get Banner Image Path
        $banner_image_path = 'front/images/banners/';
        //Delete Banner Image if exists in folder front/images/banners
        if (file_exists($banner_image_path.$bannerImage->image)) {
            unlink($banner_image_path.$bannerImage->image);
        }
        //Delete Banner Image from banners table
        Banner::where('id', $id)->delete();
        $message = "Banner Image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditBanner(Request $request, $id = null) {
        Session::put('page', 'add_edit_banner');
        if ($id == null) {
            $title = "Add Banner Image";
            $banner = new Banner;
            $message = "Banner added successfully";
        } else {
            $title = "Edit Banner Image";
            $banner = Banner::find($id);
            $message = "Banner updated successfully";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $banner->type = $data['type'];
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;

            if ($data['type'] == "Slider") {
                $width = "1920";
                $height = "720";
            } else {
                $width = "1110";
                $height = "236";
            }

            //Upload Banner Image
            if($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName= rand(111, 99999).'.'.$extension;
                    
                    $imagePath = 'front/images/banner_images/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->resize($width, $height)->save($imagePath);
                    //Insert Image Name in banners table
                    $banner->image = $imageName;
                }
            }
            
            $banner->save();

            return redirect('admin/banners')->with('success_message', $message);
        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }
}
