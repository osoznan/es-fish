<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiMethodsGeneralWorkability extends TestCase
{
    // use LazilyRefreshDatabase;

    protected array $links = [
        '/api/category',
        '/api/category/1'
    ];

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        foreach ($this->links as $link) {
            $response = $this->json('get', '/api/category');
            $response->assertStatus(200);
        }
    }
}
