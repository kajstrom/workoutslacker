<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require "../bootstrap.php";
ini_set("display_errors", "on");
error_reporting(E_ALL);

$request = Request::createFromGlobals();

$route = new Route('/workouts', array('controller' => 'WorkoutController', 'action' => 'index'));
$routes = new RouteCollection();
$routes->add('workout_index', $route);

$context = new RequestContext('/');

$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($request->getRequestUri());

$controllerName = '\Application\Controller\\' . $parameters["controller"];

$loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/views');
$twig = new Twig_Environment($loader, array(
    'cache' => dirname(__DIR__) . '/cache/twig',
));

$controller = new $controllerName($twig, $entityManager);
/** @var Response $response */
$response = call_user_func_array([$controller, $parameters["action"] . "Action"], [$request]);

$response->send();