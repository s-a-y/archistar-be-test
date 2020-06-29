<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class PropertiesTest extends TestCase
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
     * Test path that doesn't exist
     *
     * @return void
     */
    public function testInvalidResource()
    {
        $response = $this->get('/api/properties');

        $response->assertStatus(405);
    }

    /**
     * Test property can be created
     *
     * @return void
     */
    public function testCorrectPropertyCreation()
    {
        $response = $this->postJson('/api/properties', [
            'guid' => $this->faker->uuid,
            'suburb' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test property creation can fail due to incorrect parameters
     *
     * @return void
     */
    public function testMissingMandatoryParameter()
    {
        $response = $this->postJson('/api/properties', [
            'suburb' => $this->faker->city,
            'state' => $this->faker->state,
        ]);

        $response->assertStatus(422);
    }
}
