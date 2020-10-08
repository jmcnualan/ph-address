<?php

use Database\Factories\MunicipalityFactory;
use Database\Factories\ProvinceFactory;
use Dmn\PhAddress\Models\Municipality;
use Dmn\PhAddress\Models\Province;

class ProvinceHttpTest extends TestCase
{
    /**
     * @test
     * @testdox Province list
     *
     * @return void
     */
    public function listProvince(): void
    {
        $factory = new ProvinceFactory();
        $factory->count(10)->create();
        $this->get('province');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Province list per page
     *
     * @return void
     */
    public function listProvincePerPage(): void
    {
        $factory = new ProvinceFactory();
        $factory->count(10)->create();
        $this->get('province?per_page=2');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(2, count($response['data']));
    }

    /**
     * @test
     * @testdox Filter provinces
     *
     * @return void
     */
    public function filterProvince(): void
    {
        $factory = new ProvinceFactory();
        $factory->count(10)->create();
        $region = Province::first();
        $this->get('province?q=' . $region->name);

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(1, count($response['data']));
    }

    /**
     * @test
     * @testdox Municipalities under a province
     *
     * @return void
     */
    public function municipalitiesInProvince(): void
    {
        $provinceFactory = new ProvinceFactory();
        $factory         = new MunicipalityFactory();
        $province        = $provinceFactory->create();
        $factory->count(10)->create(['province_code' => $province->code]);

        $this->get('province/' . $province->code . '/municipality');
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Provinces under a region filter
     *
     * @return void
     */
    public function filterMunicipalitiesInProvince(): void
    {
        $provinceFactory = new ProvinceFactory();
        $factory         = new MunicipalityFactory();
        $province        = $provinceFactory->create();
        $factory->count(10)->create(['province_code' => $province->code]);

        $municipality = Municipality::first();

        $this->get('province/' . $province->code . '/municipality?q=' . $municipality->name);
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(1, count($response['data']));
    }
}
