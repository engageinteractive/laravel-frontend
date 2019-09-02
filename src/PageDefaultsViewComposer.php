<?php

namespace EngageInteractive\LaravelFrontend;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

abstract class PageDefaultsViewComposer
{
    /**
     * Laravel Frontend Config Provider.
     *
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * Creates a FrontendViewComposer instance.
     *
     * @param ConfigProvider  $configProvider
     * @return void
     */
    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * Binds fallback values for both frontend and backend templates that are
     * used on ever page, such as meta data. Existing values are meged over the
     * defaults so any values provided by the view will always exist. Merge is
     * only one level deep.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $existing = $view->getData($view);

        // Merge in the page defaults into the view data. All values of the defaults
        // should be arrays at the top level, such as "page" and "model". These defaults
        // are merged into the arrays (if provided) of the current view.
        foreach ($this->defaults($view) ?? [] as $key => $value) {
            $defaults = ($value ?? []);
            $provided = (Arr::get($existing, $key) ?? []);

            $view->with($key, array_merge([], $defaults, $provided));
        }
    }

    /**
     * Checks to see if frontend variables should be applied.
     *
     * @param  View  $view
     * @return bool
     */
    protected function shouldApplyFrontend(View $view)
    {
        if (!$this->configProvider->get('enabled')) {
            return false;
        }

        return Arr::get($view->getData(), $this->configProvider->get('template_flag'));
    }

    /**
     * Gets the default values for the page, either for the frontend templates,
     * or the main application (e.g. production constants or database driven.)
     *
     * @param  View  $view
     * @return array
     */
    protected function defaults(View $view)
    {
        return ($this->shouldApplyFrontend($view))
            ? $this->defaultsForFrontend()
            : $this->defaultsForApp();
    }

    /**
     * Gets frontend default variables.
     *
     * @return array
     */
    abstract protected function defaultsForFrontend();

    /**
     * Gets application default variables (i.e. ones used when not in the
     * frontend templates.)
     *
     * @return array
     */
    abstract protected function defaultsForApp();
}
