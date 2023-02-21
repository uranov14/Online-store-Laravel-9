<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankRecords = [
            [
                'id'=>1,
                'vendor_id'=>1,
                'account_holder_name'=>'John Cena',
                'account_number'=>'8748595746635',
                'bank_name'=>'Privat',
                'bank_ifsc_code'=>'35466354',
            ],
        ];

        VendorsBankDetail::insert($bankRecords);
    }
}
