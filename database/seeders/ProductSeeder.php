<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 't shirt',
                'description' => 'cotton t shirts',
                'discount' => '5',
                'image' => 'product_images/ZBpFz40GvLmpbG0ye2dNNVQLfvImIVuXqxB...',
                'price' => '500',
                'sizes' => 'S,M,L,XL',
                'category_id' => 1,
                'created_at' => '2025-05-06 05:34:03',
                'updated_at' => '2025-05-06 05:34:03',
            ],
            [
                'name' => 'saree',
                'description' => 'cotton saree',
                'discount' => null,
                'image' => 'product_images/W6LGgTMgAhZLDimAq3ixAn6jR1eWqBtX88f...',
                'price' => '1200',
                'sizes' => 'S',
                'category_id' => 2,
                'created_at' => '2025-07-07 08:21:55',
                'updated_at' => '2025-07-07 08:21:55',
            ],
            [
                'name' => 'cotton shirt',
                'description' => 'cotton shirt for men',
                'discount' => null,
                'image' => 'product_images/9kpENKmUYRkV7v3LS4c53pUBTai9uunhzCt...',
                'price' => '1500',
                'sizes' => 'S,M,L,XL',
                'category_id' => 1,
                'created_at' => '2025-07-08 05:27:04',
                'updated_at' => '2025-07-08 05:27:04',
            ],
            [
                'name' => 'Check Shirt',
                'description' => 'Check shirt for men',
                'discount' => null,
                'image' => 'product_images/CPKbgVcMoQ4tWtkClleKpXMhIdPr0Yu7XZE...',
                'price' => '2000',
                'sizes' => 'S,M,L,XL',
                'category_id' => 1,
                'created_at' => '2025-07-08 05:33:00',
                'updated_at' => '2025-07-08 05:33:00',
            ],
            [
                'name' => 'Men Jeans',
                'description' => 'Jeans For Men',
                'discount' => null,
                'image' => 'product_images/dQwrfOUUEhGu3g1o9kr5ZrARDxhpcPrRXf2...',
                'price' => '2000',
                'sizes' => 'S,M,L,XL',
                'category_id' => 1,
                'created_at' => '2025-07-08 05:35:55',
                'updated_at' => '2025-07-08 05:35:55',
            ],
            [
                'name' => 'Shorts',
                'description' => 'Shorts for men',
                'discount' => null,
                'image' => 'product_images/wLeRQILrZu4ey15oo9CBq6sYPtJSZ57PYtI...',
                'price' => '1000',
                'sizes' => 'S,M,L,XL',
                'category_id' => 1,
                'created_at' => '2025-07-08 05:44:06',
                'updated_at' => '2025-07-08 05:44:06',
            ]
        ]);
    }
}
