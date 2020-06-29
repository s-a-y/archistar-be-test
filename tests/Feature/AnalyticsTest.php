<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create();
    }

    /**
     * Test analytic can be created
     *
     * @return void
     */
    public function testListingAnalyticsForProperty()
    {
        $response = $this->get('/api/properties/2/analytics');

        $response->assertStatus(200);
    }

    /**
     * Test analytic can be created
     *
     * @return void
     */
    public function testCorrectAnalyticCreation()
    {
        $response = $this->postJson('/api/properties/2/analytics', [
            'analytic_type_id' => 1,
            'value' => '123',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test analytic can be updated
     *
     * @return void
     */
    public function testCorrectAnalyticUpdate()
    {
        $response = $this->putJson('/api/properties/2/analytics/2', [
            'analytic_type_id' => 2,
            'value' => '124',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test analytic update can fail
     *
     * @return void
     */
    public function testMissingMandatoryParameter()
    {
        $response = $this->putJson('/api/properties/2/analytics/2', [
            'analytic_type_id' => 2,
        ]);

        $response->assertStatus(422);
    }
}
