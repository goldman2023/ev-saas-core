<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // the entry point to the legacy app
        $response = $this->get('/');

        // replace 'welcome' with a string on the home page
        $response->assertStatus(200);
    }
}
