<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
            'biz_id'        => 1,
            'name'          => 'Product 1',
            'description'   => 'Product 1 description',
            'public'        => 1,
            'amount'        => 5,
            'measure'       => '%',
            'lead_reward'   => 15,
        ]);

        \App\Product::create([
            'biz_id'        => 1,
            'name'          => 'Product 2',
            'description'   => 'Product 2 description',
            'public'        => 1,
            'amount'        => 50,
            'measure'       => '$',
            'lead_reward'   => 25,
        ]);


        \App\Product::create([
            'biz_id'        => 1,
            'name'          => 'Product 3',
            'description'   => 'Product 3 description',
            'public'        => 0,
            'amount'        => 15,
            'measure'       => '%',
            'lead_reward'   => 50,
        ]);

        \App\Product::create([
            'biz_id'        => 1,
            'name'          => 'Product 4',
            'description'   => 'Product 4 description',
            'public'        => 1,
            'amount'        => 100,
            'measure'       => '$',
            'lead_reward'   => 25,
        ]);

    }
}
