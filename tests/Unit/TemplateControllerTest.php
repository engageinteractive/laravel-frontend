<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\File;
use Illuminate\View\FileViewFinder;
use Mockery as m;

use Tests\TestCase;
use EngageInteractive\LaravelFrontend\ServiceProvider;
use EngageInteractive\LaravelFrontend\TemplateProvider;

class TemplateControllerTest extends TestCase
{
    public function test_When_NoStatus_Then_Returns200()
    {
        $response = $this->post(route('frontend.echo'));
        $response->assertStatus(200);
    }

    public function test_When_StatusSpecified_Then_ReturnsStatus()
    {
        $expected = 301;
        $response = $this->post(route('frontend.echo', [ 'status' => $expected ]));
        $response->assertStatus($expected);
    }
}


