<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Enums\VerficationStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
            'verified' => $verified= $this->faker
                ->randomElement([VerficationStatus::UNVERIFIED,VerficationStatus::VERIFIED]),
            'verification_token' => $verified ? null : User::generateVerificationCode(),
            'admin'=>$this->faker
                ->randomElement([Role::REGULAR,Role::ADMIN]),
        ];
    }
}
