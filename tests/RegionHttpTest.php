<?php

use Database\Factories\ProvinceFactory;
use Database\Factories\RegionFactory;
use Dmn\PhAddress\Models\Province;
use Dmn\PhAddress\Models\Region;

class RegionHttpTest extends TestCase
{
    /**
     * @test
     * @testdox Region list
     *
     * @return void
     */
    public function listRegion(): void
    {
        $factory = new RegionFactory();
        $factory->count(10)->create();
        $this->get('region');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Region list per page
     *
     * @return void
     */
    public function listRegionPerPage(): void
    {
        $factory = new RegionFactory();
        $factory->count(10)->create();
        $this->get('region?per_page=2');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(2, count($response['data']));
    }

    /**
     * @test
     * @testdox Filter regions
     *
     * @return void
     */
    public function filterRegion(): void
    {
        $factory = new RegionFactory();
        $factory->count(10)->create();
        $region = Region::first();
        $this->get('region?q=' . $region->name);

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(1, count($response['data']));
    }

    /**
     * @test
     * @testdox Provinces under a region
     *
     * @return void
     */
    public function provincesInRegion(): void
    {
        $regionFactory = new RegionFactory();
        $factory       = new ProvinceFactory();
        $region        = $regionFactory->create();
        $factory->count(10)->create(['region_code' => $region->code]);

        $this->get('region/' . $region->code . '/province');
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
    public function filterProvincesInRegion(): void
    {
        $regionFactory = new RegionFactory();
        $factory       = new ProvinceFactory();
        $region        = $regionFactory->create();
        $factory->count(10)->create(['region_code' => $region->code]);

        $province = Province::first();

        $this->get('region/' . $region->code . '/province?q=' . $province->name);
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(1, count($response['data']));
    }
}
