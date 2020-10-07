<?php

namespace Database\Factories;

use Dmn\PhAddress\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $factory = new RegionFactory();
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->lexify('?????????'),
            'region_code' => $factory->create(),
        ];
    }
}
