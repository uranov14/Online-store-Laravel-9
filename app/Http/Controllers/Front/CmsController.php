<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;

class CmsController extends Controller
{
    public function cmsPage(Request $request) {
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/", "", $currentRoute);
        /* echo $currentRoute; die; */
        $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();

        if (in_array($currentRoute, $cmsUrls)) {
            $cmsPageDetails = CmsPage::where('url', $currentRoute)->first()->toArray();
            return view('front.pages.cms_page')->with(compact('cmsPageDetails'));
        } else {
            abort(404);
        }
    }
}
