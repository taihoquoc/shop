<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::firstOrCreate(
            [
                'name' => 'Gucci'
            ]
        );
        Brand::firstOrCreate(
            [
                'name' => 'Zara'
            ]
        );
    }
}
