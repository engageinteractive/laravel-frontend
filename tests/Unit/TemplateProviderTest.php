<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;

use Tests\TestCase;
use Engage\LaravelFrontend\TemplateProvider;

class TemplateProviderTest extends TestCase
{
    public function test_When_RetrievingTemplatesPaths_Then_StorageFacadeShouldBeUsed()
    {
        Storage::fake('local');
        Storage::put('resources/views/frontend/test.blade.php', '');

        $this->assertEquals([ 'frontend/test' ], app(TemplateProvider::class)->allTemplatesPaths()->toArray());
    }
}
