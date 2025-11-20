<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
	protected $model = \App\Models\Product::class;

	public function definition(): array
	{
		return [
			'name' => $this->faker->words(3, true),
			'description' => $this->faker->sentence(10),
			'price' => $this->faker->randomFloat(2, 10, 1000),
			'stock' => $this->faker->numberBetween(0, 500),
			'category' => $this->faker->randomElement(['Electronics', 'Clothes', 'Books', 'Toys', 'Food']),
		];
	}
}
