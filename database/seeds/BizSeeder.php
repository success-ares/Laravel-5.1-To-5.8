<?php

use Illuminate\Database\Seeder;

class BizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Biz::create([
            'user_id'   => 3,
            'biz_name'  => 'Topling',
            'name_alias'=> 'topling',
            'phone'     => '7-777-555-000',
            'email'     => 'alexusmai@gmail.com',
            'contact_person' => 'Alex',
            'description'   => 'Some text',
            'category_code' => 2022,
        ]);
    }
}
