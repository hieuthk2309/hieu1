<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
	public function run(): void
	{
		// Tạo 10.000 sản phẩm
		Product::factory()->count(10000)->create();
	}
}
