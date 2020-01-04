<?php

use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \App\Referral::create([
             'user_id'      => 1,
             'parent_id'    => 3,
             'product_id'   => 1,
             'status'       => 'Pending contact',
             'code'         => str_random(50),
             'seller'       => 1,
         ]);

        \App\Referral::create([
            'user_id'      => 1,
            'parent_id'    => 3,
            'product_id'   => 2,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 1,
        ]);

        \App\Referral::create([
            'user_id'      => 1,
            'parent_id'    => 3,
            'product_id'   => 4,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 1,
        ]);

        \App\Referral::create([
            'user_id'      => 2,
            'parent_id'    => 3,
            'product_id'   => 3,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 1,
        ]);

        \App\Referral::create([
            'user_id'      => 2,
            'parent_id'    => 3,
            'product_id'   => 4,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 1,
        ]);

        \App\Referral::create([
            'user_id'      => 5,
            'parent_id'    => 1,
            'product_id'   => 1,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 0,
        ]);

        \App\Referral::create([
            'user_id'      => 5,
            'parent_id'    => 2,
            'product_id'   => 3,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 0,
        ]);

        \App\Referral::create([
            'user_id'      => 6,
            'parent_id'    => 2,
            'product_id'   => 4,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'seller'       => 0,
        ]);

        \App\Referral::create([
            'user_id'      => 6,
            'parent_id'    => 1,
            'product_id'   => 1,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'value'        => 150,
            'seller'       => 0,
        ]);

        \App\Referral::create([
            'user_id'      => 7,
            'parent_id'    => 2,
            'product_id'   => 4,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'value'        => 300,
            'seller'       => 0,
        ]);

        \App\Referral::create([
            'user_id'      => 7,
            'parent_id'    => 2,
            'product_id'   => 3,
            'status'       => 'Pending contact',
            'code'         => str_random(50),
            'value'        => 770,
            'seller'       => 0,
        ]);
    }
}
