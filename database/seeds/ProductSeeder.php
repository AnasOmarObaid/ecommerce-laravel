<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['iphone', 'anas book'];
        $id = 1;
        foreach ($products as $product) {
            Product::create([
                'name'  => $product,
                'description'   => 'demo description',
                'purchase_price'    => 20,
                'sale_price'    => 50,
                'stock' => 90,
                'department_id' => $id,
                'user_id'   => 1,
            ]);
            $id++;
        } //-- end foreach
    } //-- end of run

}//-- end of product seeder
