<?php
 
// framework/front.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
 
    return new Response(ob_get_clean());
}

// crea petición desde globales PHP
$request = Request::createFromGlobals();

// carga rutas de la app
$routes = include __DIR__.'/../src/app.php';

// obtiene contexto de la petición
$context = new Routing\RequestContext();
$context->fromRequest($request);

// crea nuevo matcher seteando contexto y la tabla de rutas de la app
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// crea un controller resolver
$resolver = new HttpKernel\Controller\ControllerResolver();

// crea una instancia del framework
$framework = new Simplex\Framework($matcher, $resolver);

// usa el handle del framework para resolver el request en un response
$response = $framework->handle($request);

//var_dump($response);die;
 
// envía respuesta
$response->send();