<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Code>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create('es_ES');
        $users = User::all()->pluck('id');
        return [
            'code' => Str::random(15),
            'user_id' => $faker->randomElement($users),
        ];
    }
}