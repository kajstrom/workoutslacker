<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Zend\Diactoros\ServerRequestFactory;

require "../bootstrap.php";
ini_set("display_errors", "on");
error_reporting(E_ALL);

$request = ServerRequestFactory::fromGlobals();

$workoutsListRoute = new Route('/workouts', array('controller' => 'WorkoutController', 'action' => 'index'));
$addWorkoutRoute = new Route("/workouts/add", ["controller" => "WorkoutController", "action" => "add"]);
$showWorkoutRoute = new Route("/workouts/show/{workoutId}", ["controller" => "WorkoutController", "action" => "show"]);
$addWorkoutExerciseRoute = new Route("/workouts/{workoutId}/exercises/add", ["controller" => "WorkoutExerciseController", "action" => "add"]);
$routes = new RouteCollection();
$routes->add('workout_index', $workoutsListRoute);
$routes->add("workout_add", $addWorkoutRoute);
$routes->add("workout_show", $showWorkoutRoute);
$routes->add("workout_exercise_add", $addWorkoutExerciseRoute);

$context = new RequestContext('/');

$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($request->getRequestTarget());

$controllerName = '\Adapters\Web\\' . $parameters["controller"];

$loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/views');
$twig = new Twig_Environment($loader, array(
    'cache' => dirname(__DIR__) . '/cache/twig',
));

$controller = new $controllerName($twig, $entityManager);
$action = $parameters["action"];

unset($parameters["action"]);
unset($parameters["controller"]);

$params = array_merge([$request], array_values($parameters));
/** @var Response $response */
$response = call_user_func_array([$controller, $action . "Action"], $params);

$response->send();