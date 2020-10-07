<?php

use Database\Factories\BarangayFactory;
use Dmn\PhAddress\Example\Controller;
use Laravel\Lumen\Testing\TestCase;

class AddressTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function createApplication()
    {
        return require __DIR__ . '/bootstrap.php';
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
    }

    /**
     * Run the database migrations for the application.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $migrationPath = __DIR__ . '/../src/database/migrations';

        $this->artisan(
            'migrate:fresh --realpath --path="'
            . $migrationPath
            . '"'
        );

        $this->beforeApplicationDestroyed(function () use ($migrationPath) {
            $this->artisan(
                'migrate:rollback --realpath --path="'
                . $migrationPath
                . '"'
            );
        });
    }

    /**
     * @test
     * @testdox Seeder
     *
     * @return void
     */
    // public function seeder(): void
    // {
    // $this->artisan('db:seed --class=AddressSeeder');
    // $this->seeInDatabase('barangays', ['code' => '168507009']);
    // }

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
            ->post('/', Controller::class . '@testWithoutDependency');

        $this->post('/', [
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
            ->post('/', Controller::class . '@testWithDependency');

        $this->post('/', [
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
            ->post('/', Controller::class . '@testWithDependencyInvalid');

        $this->post('/', [
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
