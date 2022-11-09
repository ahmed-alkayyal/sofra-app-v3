<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Region::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'city_id'=>10,
//            'city_id'=>rand(1,20),
        ];
    }
}
