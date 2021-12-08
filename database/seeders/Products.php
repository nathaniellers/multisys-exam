<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Mouse', 'available_stock' => 10],
            ['name' => 'Keyboard', 'available_stock' => 10],
        ];
        DB::table('products')->insert($data);
    }
}
