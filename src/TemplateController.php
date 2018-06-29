<?php

namespace Engage\LaravelFrontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TemplateController extends Controller
{
    use Concerns\InteractsWithConfigProvider;

    /**
     * Creates an instance of TemplateController
     *
     * @param ConfigProvider  $configProvider
     * @return void
     */
    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * Lists all frontend templates.
     *
     * @param TemplateProvider  $service
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateProvider $service)
    {
        $view_path = $this->configProvider
            ->get('index_template_path');

        $templates = $service->allTemplatesPaths()
            ->prepend($this->getRoutePath())
            ->toArray();

        if (!view()->exists($view_path)) {
            return abort(404);
        }

        return view($view_path)->with(compact('templates'));
    }

    /**
     * Shows a frontend template.
     *
     * @param string  $template  relative path of the template.
     * @return \Illuminate\Http\Response
     */
    public function show(string $template)
    {
        return view($this->getTemplatePath($template));
    }

    /**
     * Echo response endpoint that allows for custom status and json payload.
     *
     * @param Request
     * @return \Illuminate\Http\Response
     */
    public function echo(Request $request)
    {
        $status = $request->query('status') ?: 200;
        $json = $request->query('json');

        if ($json) {
            return response()->json($json, $status);
        } else {
            return response('', $status);
        }
    }
}
