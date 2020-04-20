<?php

namespace Engage\LaravelFrontend\Templates;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Engage\LaravelFrontend\Config;
use Engage\LaravelFrontend\Routing;

class TemplateController extends Controller
{
    /**
     * Lists all frontend templates.
     *
     * @param \Engage\LaravelFrontend\Templates\TemplateService $service
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateService $service)
    {
        $templates = $service->getTemplates();

        return View::first([
                'app/templates',
                'frontend::frontend/index',
            ])
            ->with('templates', $templates)
            ->with(Config::get('template_flag'), true)
            ->with('links', [
                'show_styleguide' => Config::get('show_styleguide', false),
                'styleguide_uri' => Routing::getTemplateRoute('styleguide/index'),
            ]);
    }

    /**
     * Shows a frontend template.
     *
     * @param string  $template  relative path of the template.
     * @param \Engage\LaravelFrontend\Templates\TemplateService $service
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(string $template, TemplateService $service)
    {
        return view($service->getTemplatePath($template))
            ->with(Config::get('template_flag'), true);
    }

    /**
     * Echo response endpoint that allows for custom status and json payload.
     *
     * @param \Illuminate\Http\Request
     * 
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
