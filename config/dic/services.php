<?php
use Adapters\Web\WorkoutController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/** @var ContainerBuilder $container */

$paths = array(APP_PATH . "/config/doctrine");
$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$container->set(EntityManager::class, $entityManager);
$container->register(WorkoutController::class, WorkoutController::class)
    ->addArgument(new Reference(Twig_Environment::class))
    ->addArgument(new Reference(EntityManager::class));
$container->register(Twig_Environment::class, Twig_Environment::class)
    ->addArgument(new Reference(Twig_Loader_Filesystem::class))
    ->addArgument(["cache" => APP_PATH . "/cache/twig"]);
$container->register(Twig_Loader_Filesystem::class, Twig_Loader_Filesystem::class)
    ->addArgument(APP_PATH . "/views");
