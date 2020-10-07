<?php

namespace Database\Factories;

use Database\Factories\ProvinceFactory;
use Dmn\PhAddress\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

class MunicipalityFactory extends Factory
{
    protected $model = Municipality::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $factory = new ProvinceFactory();
        $province = $factory->create();
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->lexify('?????????'),
            'region_code' => $province->region_code,
            'province_code' => $province->code,
        ];
    }
}
