<?php
 
// framework/front.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
$dispatcher->addSubscriber(new Simplex\GoogleListener());

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
 
    return new Response(ob_get_clean());
}

// crea petición desde globales PHP
$request = Request::createFromGlobals();

//var_dump($request);die;

// carga rutas de la app
$routes = include __DIR__.'/../src/app.php';

//var_dump($routes);die;

// obtiene contexto de la petición
$context = new Routing\RequestContext();
$context->fromRequest($request);

//var_dump($context);die;

// crea nuevo matcher seteando contexto y la tabla de rutas de la app
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

//var_dump($matcher);die;

// crea un controller resolver
$resolver = new HttpKernel\Controller\ControllerResolver();

//var_dump($resolver);die;

// crea una instancia del framework
$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);

//var_dump($framework);die;

// usa el handle del framework para resolver el request en un response
$response = $framework->handle($request);

//var_dump($response);die;
 
// envía respuesta
$response->send();