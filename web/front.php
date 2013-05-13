<?php
 
// framework/front.php
 
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

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
 
try {
    // añade a los atributos de la petición la información del path
    $request->attributes->add($matcher->match($request->getPathInfo()));

    // llama a render_template pasando la petición como parámetro
    $response = call_user_func($request->attributes->get('_controller'), $request);

} catch (Routing\Exception\ResourceNotFoundException $e) {
    // crea respuesta para página no encontrada
    $response = new Response('Not Found', 404);

} catch (Exception $e) {
    // crea respuesta para excepción
    $response = new Response('An error occurred', 500);

}

//var_dump($response);die;
 
// envía respuesta
$response->send();