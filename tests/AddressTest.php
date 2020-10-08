<?php

use Database\Factories\BarangayFactory;
use Dmn\PhAddress\Example\Controller;

class AddressTest extends TestCase
{
    /**
     * @test
     * @testdox Seeder
     *
     * @return void
     */
    public function seeder(): void
    {
        $this->artisan('db:seed --class=AddressSeeder');
        $this->seeInDatabase('barangays', ['code' => '012802001']);
    }

    /**
     * @test
     * @testdox Http test without dependency
     *
     * @return void
     */
    public function httpTestWithoutDependency()
    {
        $this->app
            ->router
            ->post('test', Controller::class . '@testWithoutDependency');

        $this->post('test', [
            'region_code' => 'invalid',
            'province_code' => 'invalid',
            'municipality_code' => 'invalid',
            'barangay_code' => 'invalid',
        ]);

        $this->response->assertJsonValidationErrors([
                'region_code' => 'validation.valid_region_code',
                'province_code' => 'validation.valid_province_code',
                'municipality_code' => 'validation.valid_municipality_code',
                'barangay_code' => 'validation.valid_barangay_code',
            ], null);
    }

    /**
     * @test
     * @testdox Http test with dependency
     *
     * @return void
     */
    public function httpTestWithDependency(): void
    {
        $factory  = new BarangayFactory();
        $barangay = $factory->create();

        $this->app
            ->router
            ->post('test', Controller::class . '@testWithDependency');

        $this->post('test', [
            'region_code' => $barangay->region_code,
            'province_code' => $barangay->province_code,
            'municipality_code' => $barangay->municipality_code,
            'barangay_code' => $barangay->code,
        ]);

        $this->assertResponseOk();
    }

    /**
     * @test
     * @testdox Http test with dependency
     *
     * @return void
     */
    public function httpTestWithDependencyInvalid(): void
    {
        $factory  = new BarangayFactory();
        $barangay = $factory->create();

        $this->app
            ->router
            ->post('test', Controller::class . '@testWithDependencyInvalid');

        $this->post('test', [
            'region_code' => $barangay->region_code,
            'province_code' => $barangay->province_code,
            'municipality_code' => $barangay->municipality_code,
            'barangay_code' => $barangay->code,
        ]);

        $this->response->assertJsonValidationErrors([
                'province_code' => 'validation.valid_province_code',
                'municipality_code' => 'validation.valid_municipality_code',
                'barangay_code' => 'validation.valid_barangay_code',
            ], null);
    }
}
