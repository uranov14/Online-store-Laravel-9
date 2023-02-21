<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            [
                'id'=>1,
                'section_id'=>2,
                'category_id'=>4,
                'brand_id'=>4,
                'vendor_id'=>1,
                'admin_id'=>0,
                'admin_type'=>'vendor',
                'product_name'=>'Redmi Note 11',
                'product_code'=>'RN11',
                'product_color'=>'Blue',
                'product_price'=>10000.36,
                'product_discount'=>10.0,
                'product_weight'=>500,
                'product_image'=>'',
                'product_video'=>'',
                'description'=>'',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'is_featured'=>'Yes',
                'status'=>1
            ],
            [
                'id'=>2,
                'section_id'=>1,
                'category_id'=>9,
                'brand_id'=>2,
                'vendor_id'=>0,
                'admin_id'=>1,
                'admin_type'=>'admin',
                'product_name'=>'Red Casual T-Shirt',
                'product_code'=>'RC001',
                'product_color'=>'Red',
                'product_price'=>156,
                'product_discount'=>20,
                'product_weight'=>200,
                'product_image'=>'',
                'product_video'=>'',
                'description'=>'',
                'meta_title'=>'',
                'meta_description'=>'',
                'meta_keywords'=>'',
                'is_featured'=>'Yes',
                'status'=>1
            ],
        ];

        Product::insert($productRecords);
    }
}