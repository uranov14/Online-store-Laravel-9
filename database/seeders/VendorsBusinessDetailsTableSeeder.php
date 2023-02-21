<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            [
                'id'=>1,
                'shop_name'=>'John Electronics Store',
                'shop_address'=>'1234-SCF',
                'vendor_id'=>1,
                'shop_city'=>'New Delfi',
                'shop_state'=>'Delfi',
                'shop_country'=>'India',
                'shop_pincode'=>'110231',
                'shop_mobile'=>'9570500010',
                'shop_website'=>'sitemakers.in',
                'shop_email'=>'john@admin.com',
                'address_proof'=>'Passport',
                'address_proof_image'=>'test.jpg',
                'business_license_number'=>'12345',
                'gst_number'=>'374665773',
                'pan_number'=>'385869690',
            ],
        ];

        VendorsBusinessDetail::insert($vendorRecords);
    }
}
