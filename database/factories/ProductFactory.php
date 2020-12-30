<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Enums\Status;
use App\Enums\VerficationStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(1,10),
            'status' => $verified= $this->faker
                ->randomElement([Status::UNAVAILABLE,Status::AVAILABLE]),
            'image'=>$this->faker
                ->randomElement(['img-1.jpg','img-2.jpg','img-3.jpg']),
            'seller_id'=>User::all()->random()->id,
        ];
    }
}
