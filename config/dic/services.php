<?php
use Adapters\Persistence\Doctrine\Logging\ExerciseRepository;
use Adapters\Persistence\Doctrine\Logging\ExerciseTypeRepository;
use Adapters\Persistence\Doctrine\Logging\WorkoutRepository;
use Adapters\Web\WorkoutController;
use Adapters\Web\WorkoutExerciseController;
use Application\WorkoutService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Domain\Logging\Model\Exercise\Exercise;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\Workout;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/** @var ContainerBuilder $container */

$paths = array(APP_PATH . "/config/doctrine");
$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$container->set(EntityManager::class, $entityManager);
$container->register(Twig_Environment::class, Twig_Environment::class)
    ->addArgument(new Reference(Twig_Loader_Filesystem::class))
    ->addArgument(["cache" => APP_PATH . "/cache/twig"]);
$container->register(Twig_Loader_Filesystem::class, Twig_Loader_Filesystem::class)
    ->addArgument(APP_PATH . "/views");

//Controllers
$container->register(WorkoutController::class, WorkoutController::class)
    ->addArgument(new Reference(Twig_Environment::class))
    ->addArgument(new Reference(WorkoutService::class));

$container->register(WorkoutExerciseController::class, WorkoutExerciseController::class)
    ->addArgument(new Reference(Twig_Environment::class))
    ->addArgument(new Reference(EntityManager::class));

//Repositories
$workoutRepositoryDefinition = new Definition(WorkoutRepository::class, [Workout::class]);
$workoutRepositoryDefinition->setFactory([new Reference(EntityManager::class), "getRepository"]);
$container->setDefinition(WorkoutRepository::class, $workoutRepositoryDefinition);

$exerciseRepositoryDefinition = new Definition(ExerciseRepository::class, [Exercise::class]);
$exerciseRepositoryDefinition->setFactory([new Reference(EntityManager::class), "getRepository"]);
$container->setDefinition(ExerciseRepository::class, $exerciseRepositoryDefinition);

$exerciseTypeRepositoryDefinition = new Definition(ExerciseTypeRepository::class, [ExerciseType::class]);
$exerciseTypeRepositoryDefinition->setFactory([new Reference(EntityManager::class), "getRepository"]);
$container->setDefinition(ExerciseTypeRepository::class, $exerciseTypeRepositoryDefinition);

//Services
$container->register(WorkoutService::class, WorkoutService::class)
    ->addArgument(new Reference(WorkoutRepository::class))
    ->addArgument(new Reference(ExerciseTypeRepository::class))
    ->addArgument(new Reference(ExerciseRepository::class));