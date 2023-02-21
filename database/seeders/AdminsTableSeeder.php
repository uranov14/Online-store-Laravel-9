<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            [
                'id'=>1,
                'name'=>'Yuriy Novikov',
                'type'=>'admin',
                'vendor_id'=>0,
                'mobile'=>'689805417',
                'email'=>'ynovikov14@gmail.com',
                'password'=>'$2a$12$Gp0U//jxGGudJlhzwN04iup0OjLFhMl15wpJsaJX7JqKCLRYwxqMe',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>2,
                'name'=>'John',
                'type'=>'vendor',
                'vendor_id'=>1,
                'mobile'=>'9570500010',
                'email'=>'john@admin.com',
                'password'=>'$2a$12$yCM7tXWs1mnKXFrR2n7wLu8GDVZUorxN.ui.rX64AeWF1.FVH0mCK',
                'image'=>'',
                'status'=>0
            ],
        ];

        Admin::insert($adminRecords);
    }
}
