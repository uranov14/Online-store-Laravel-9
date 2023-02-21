<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    public function vendorPersonal() {
        return $this->belongsTo('App\Models\Vendor', 'id');
    }

    public function vendorBusiness() {
        return $this->belongsTo('App\Models\VendorsBusinessDetail', 'id');
    }

    public function vendorBank() {
        return $this->belongsTo('App\Models\VendorsBankDetail', 'id');
    }

    /* public static function getVendorImage($vendor_id) {
        $vendorImage = Admin::select('image')->where('id', $vendor_id)->first();
        $vendorImage = json_decode(json_encode($vendorImage), true);

        return $vendorImage;
    } */
}
