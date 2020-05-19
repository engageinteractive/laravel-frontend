<?php

namespace Engage\LaravelFrontend;

use Illuminate\View\View;
use Illuminate\Support\Arr;

abstract class PageDefaultsViewComposer
{
    /**
     * Returns default data to the view, if a frontend template request
     * data provided in the templates method is overwritten on the app data.
     *
     * @param  View  $view
     * 
     * @return void
     */
    public function compose(View $view): void
    {
        if ($this->shouldApplyTemplatesData()) {
            $defaults = $this->getTemplateData();
        } else {
            $defaults = $this->app();
        }

        $dataForView = $this->getViewNormalisedData($view, $defaults);

        $view->with($dataForView);
    }

    /**
     * Returns resulting array from defaults
     * overwritten with controller data.
     * 
     * @param View $view
     * @param array $defaultsData
     * 
     * @return array
     */
    protected function getViewNormalisedData(View $view, array $defaultsData)
    {
        $viewData = Arr::dot($view->getData());

        foreach ($viewData as $key => $value) {
            Arr::set($defaultsData, $key, $value);
        }

        return $defaultsData;
    }

    /**
     * Returns true if frontend variables should be applied.
     *
     * @param  View  $view
     * 
     * @return bool
     */
    protected function shouldApplyTemplatesData(): bool
    {
        if (! Config::get('enabled')) {
            return false;
        }

        if (! Routing::isRunningTemplateRoute()) {
            return false;
        }

        return true;
    }

    /**
     * Returns resulting array from defaults overwritten
     * with templates array.
     * 
     * @return array
     */
    protected function getTemplateData(): array
    {
        $templates = Arr::dot($this->templates());
        $app = $this->app();

        if (! $templates) {
            return $app;
        }

        foreach ($templates as $key => $value) {
            Arr::set($app, $key, $value);
        }

        return $app;
    }

    /**
     * Returns developer-defined application default variables.
     *
     * @return array
     */
    abstract protected function app(): array;

    /**
     * Returns developer-defined frontend default variables.
     *
     * @return array
     */
    abstract protected function templates(): array;
}
