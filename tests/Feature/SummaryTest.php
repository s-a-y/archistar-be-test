<?php

namespace Tests\Feature;

use Tests\TestCase;

class SummaryTest extends TestCase
{
    /**
     * Test analytics can be listed for suburb
     *
     * @return void
     */
    public function testSummaryForSuburb()
    {
        $response = $this->get('/api/summary?suburb=Parramatta');

        $response->assertStatus(200);
    }

    /**
     * Test analytics can be listed for state
     *
     * @return void
     */
    public function testSummaryForState()
    {
        $response = $this->get('/api/summary?state=NSW');

        $response->assertStatus(200);
    }

    /**
     * Test analytics can be listed for country
     *
     * @return void
     */
    public function testSummaryForCountry()
    {
        $response = $this->get('/api/summary?country=Australia');

        $response->assertStatus(200);
    }
}
