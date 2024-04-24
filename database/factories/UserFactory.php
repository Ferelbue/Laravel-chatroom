<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'nickName' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$10$RffoehBoXaXy/SrY0MRnF.mmSm10iO9D64.06ND4dvq2UMshGkIim'
        ];
    }

}