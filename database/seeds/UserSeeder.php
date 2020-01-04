<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Test user 1
        \App\User::create([
            'email'         => 'ralf@futurelab.co.nz',
            'first_name'    => 'Ralf',
            'last_name'     => 'Klis',
            'phone'         => '8-800-2000-999',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'FutureLab',
            'company_url'   => 'http://futurelab.co.nz',
            'photo'         => 'avatar-1.jpg',
            'status'        => 1,
            'type'          => 'user',
            'password'      => bcrypt('123')
        ]);

        // Test user 2
        \App\User::create([
            'email'         => 'serena@futurelab.co.nz',
            'first_name'    => 'Serena',
            'last_name'     => 'Driver',
            'phone'         => '8-800-2000-100',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'FutureLab',
            'company_url'   => 'http://futurelab.co.nz',
            'photo'         => 'avatar-3.jpg',
            'status'        => 1,
            'type'          => 'user',
            'password'      => bcrypt('123')
        ]);

        // Test user 3
        \App\User::create([
            'email'         => 'email@test.dev',
            'first_name'    => 'Test',
            'last_name'     => 'Merchant',
            'phone'         => '8-800-2000-100',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'TestCompany',
            'company_url'   => 'http://google.com',
            'photo'         => 'avatar-2.jpg',
            'status'        => 1,
            'type'          => 'user',
            'business'      => 1,
            'password'      => bcrypt('123')
        ]);

        // Test admin 4
        \App\User::create([
            'email'         => 'contact@futurelab.co.nz',
            'first_name'    => 'Admin',
            'last_name'     => '',
            'phone'         => '8-800-2000-100',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'FutureLab',
            'photo'         => 'avatar-1.jpg',
            'status'        => 1,
            'type'          => 'admin',
            'password'      => bcrypt('123')
        ]);

        // Test user 5
        \App\User::create([
            'email'         => 'testuser1@futurelab.co.nz',
            'first_name'    => 'Test',
            'last_name'     => 'User1',
            'phone'         => '8-800-2000-100',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'Nice company',
            'photo'         => 'avatar-3.jpg',
            'status'        => 1,
            'type'          => 'user',
            'password'      => bcrypt('123')
        ]);

        // Test user 6
        \App\User::create([
            'email'         => 'testuser2@futurelab.co.nz',
            'first_name'    => 'Test',
            'last_name'     => 'User2',
            'phone'         => '5-500-5000-500',
            'address'       => '85B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'Some company',
            'photo'         => 'avatar-1.jpg',
            'status'        => 1,
            'type'          => 'user',
            'password'      => bcrypt('123')
        ]);

        // Test user 7
        \App\User::create([
            'email'         => 'testuser3@futurelab.co.nz',
            'first_name'    => 'Test',
            'last_name'     => 'User3',
            'phone'         => '9-900-9000-900',
            'address'       => '84B Hurstmere Road, Takapuna, Auckland, NZ',
            'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A distinctio dolores laudantium perferendis quae soluta temporibus. Aperiam deserunt doloribus ea error, expedita illum impedit iure, libero necessitatibus nulla quisquam totam.',
            'company'       => 'Company - 33',
            'photo'         => 'avatar-2.jpg',
            'status'        => 1,
            'type'          => 'user',
            'password'      => bcrypt('123')
        ]);
    }
}
