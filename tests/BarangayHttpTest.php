<?php

use Database\Factories\BarangayFactory;

class BarangayHttpTest extends TestCase
{
    /**
     * @test
     * @testdox Barangay list
     *
     * @return void
     */
    public function listBarangay(): void
    {
        $factory = new BarangayFactory();
        $factory->count(10)->create();
        $this->get('barangay');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Municipality list per page
     *
     * @return void
     */
    public function listMunicipalityPerPage(): void
    {
        $factory = new BarangayFactory();
        $factory->count(10)->create();
        $this->get('barangay?per_page=2');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(2, count($response['data']));
    }
}
