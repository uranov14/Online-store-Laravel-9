<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
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
                'name'=>'John',
                'address'=>'CP-121',
                'city'=>'New York',
                'state'=>'Alabama',
                'country'=>'USA',
                'pincode'=>'110101',
                'mobile'=>'9570500010',
                'email'=>'john@admin.com',
                'status'=>0
            ],
        ];

        Vendor::insert($vendorRecords);
    }
}
