<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Mockery as m;

use EngageInteractive\LaravelFrontend\PageDefaultsViewComposer;
use EngageInteractive\LaravelFrontend\ConfigProvider;

use Tests\TestCase;

class PageDefaultsViewComposerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->configProvider = $this->app->make(ConfigProvider::class);
    }

    public function test_compose_DoesNotMergeAnythingIfNullValuesGiven()
    {
        $composer = new class($this->configProvider) extends PageDefaultsViewComposer {
            protected function defaultsForFrontend() { return null; }
            protected function defaultsForApp() { return null; }
        };

        // Given
        $view = m::mock(View::class)
            ->makePartial()
            ->with($this->configProvider->get('template_flag'), true);

        $expected = $view->getData();

        // When
        $composer->compose($view);

        // Then
        $this->assertEquals($expected, $view->getData());
    }

    public function test_compose_MergesInNewKeysWhenValuesGiven()
    {
        $composer = new class($this->configProvider) extends PageDefaultsViewComposer {
            protected function defaultsForFrontend()
            {
                return [
                    'page' => [
                        'example' => true,
                    ],
                ];
            }

            protected function defaultsForApp() { return null; }
        };

        // Given
        $view = m::mock(View::class)
            ->makePartial()
            ->with($this->configProvider->get('template_flag'), true);

        $expected = $view->getData();
        $expected['page'] = [ 'example' => true ];

        // When
        $composer->compose($view);

        // Then
        $this->assertEquals($expected, $view->getData());
    }

    public function test_compose_MergesExistingsKeysWhenValuesGiven()
    {
        $composer = new class($this->configProvider) extends PageDefaultsViewComposer {
            protected function defaultsForFrontend()
            {
                return [
                    'page' => [
                        'first' => 'remains',
                        'example' => true,
                    ],
                ];
            }

            protected function defaultsForApp() { return null; }
        };

        // Given
        $view = m::mock(View::class)
            ->makePartial()
            ->with($this->configProvider->get('template_flag'), true)
            ->with('page', [ 'example' => false ]);

        $expected = $view->getData();
        $expected['page'] = [
            'first' => 'remains',
            'example' => false,
        ];

        // When
        $composer->compose($view);

        // Then
        $this->assertEquals($expected, $view->getData());
    }
}
