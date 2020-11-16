<?php

use Database\Factories\BarangayFactory;
use Database\Factories\CountryFactory;
use Dmn\PhAddress\Models\Country;
use PHPUnit\Framework\Constraint\Count;

class CountryHttpTest extends TestCase
{
    /**
     * @test
     * @testdox Barangay list
     *
     * @return void
     */
    public function list(): void
    {
        $factory = new CountryFactory();
        $factory->count(10)->create();
        $this->get('country');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Barangay list per page
     *
     * @return void
     */
    public function perPage(): void
    {
        $factory = new CountryFactory();
        $factory->count(10)->create();
        $this->get('country?per_page=2');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(2, count($response['data']));
    }

    /**
     * @test
     * @testdox With filter
     *
     * @return void
     */
    public function filter(): void
    {
        $factory = new CountryFactory();
        $factory->create(['code' => 'wa', 'name' => 'country name']);
        $factory->create(['code' => 'wa1', 'name' => 'another test']);
        $country = Country::first();
        $this->get('country?q=' . $country->name);

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(1, count($response['data']));
    }
}
