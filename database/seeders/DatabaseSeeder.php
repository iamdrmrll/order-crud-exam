<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /**
         * ----------------------------------------------------------------
         * Users
         * ----------------------------------------------------------------
         */
        $users = [
            [
                'first_name'    => 'John',
                'last_name'     => 'Doe',
                'email_address' => 'john@example.com',
                'mobile_number' => '09876543210',
                'address'       => '123 Main Street',
                'password'      => bcrypt('1234'),
                'status'        => 1
            ],
            [
                'first_name'    => 'Juan',
                'last_name'     => 'Dela Cruz',
                'email_address' => 'juan@example.com',
                'mobile_number' => '09876543210',
                'address'       => '123 Main Street',
                'password'      => bcrypt('1234'),
                'status'        => true
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }

        /**
         * ----------------------------------------------------------------
         * Products
         * ----------------------------------------------------------------
         */
        $products = [
            [
                'product_name'        => 'Product 1',
                'product_description' => 'Desc for Product 1',
                'quantity'            => 5,
                'price'               => 10,
                'status'              => true
            ],
            [
                'product_name'        => 'Product 2',
                'product_description' => 'Desc for Product 2',
                'quantity'            => 3,
                'price'               => 8,
                'status'              => true
            ],
        ];
        foreach ($products as $product) {
            Product::create($product);
        }

    }
}
