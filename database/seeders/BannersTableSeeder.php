<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            [
                'id'=>2,
                'type'=>'Slider',
                'image'=>'banner-1.png',
                'link'=>'spring-collection',
                'title'=>'Spring Collection',
                'alt'=>'Spring Collection banner',
                'status'=>1,
            ],
            [
                'id'=>3,
                'type'=>'Slider',
                'image'=>'banner-2.png',
                'link'=>'tops',
                'title'=>'Tops',
                'alt'=>'Tops banner',
                'status'=>1,
            ]
        ];
        Banner::insert($bannerRecords);
    }
}
