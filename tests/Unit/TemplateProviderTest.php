<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\File;

use Tests\TestCase;
use EngageInteractive\LaravelFrontend\TemplateProvider;

class TemplateProviderTest extends TestCase
{
    public function test_When_RetrievingTemplatesPaths_Then_StorageFacadeShouldBeUsed()
    {
        File::makeDirectory(resource_path('views/frontend'), 0755, $recursive = true, $force = true);
        File::cleanDirectory(resource_path('views/frontend'));
        File::put(resource_path('views/frontend/test.blade.php'), '');

        $this->assertEquals([ 'frontend/test' ], app(TemplateProvider::class)->allTemplatesPaths()->toArray());
    }
}
