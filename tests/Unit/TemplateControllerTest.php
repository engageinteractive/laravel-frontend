<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\File;
use Mockery as m;

use Tests\TestCase;

class TemplateControllerTest extends TestCase
{
    public function test_echo_Returns200ByDefault()
    {
        // When
        $response = $this->post(route('frontend.echo'));

        // Then
        $response->assertStatus(200);
    }

    public function test_echo_ReturnsSuppliedStatus()
    {
        // Given
        $expected = 301;

        // When
        $response = $this->post(route('frontend.echo', [ 'status' => $expected ]));

        // Then
        $response->assertStatus($expected);
    }

    public function test_echo_RetunsSuppliedJson()
    {
        // Given
        $expected = [ 'a' => 10 ];

        // When
        $response = $this->post(route('frontend.echo', [ 'json' => $expected ]));

        // Then
        $response->assertJson($expected);
    }
}
