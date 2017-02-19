<?php
use Codeception\Util\Fixtures;
use Domain\Logging\Infrastructure\Persistence\Doctrine\ExerciseTypeRepository;
use Domain\Logging\Infrastructure\Persistence\Doctrine\WorkoutRepository;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\Time;
use Domain\Logging\Model\Workout\Workout;

$I = new AcceptanceTester($scenario);
$I->wantTo('add an exercise to a workout');

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = Fixtures::get("entityManager");
/** @var WorkoutRepository $workoutRepository */
$workoutRepository = $entityManager->getRepository(Workout::class);
$workoutId = $workoutRepository->nextId();

/** @var ExerciseTypeRepository $exerciseTypeRepository */
$exerciseTypeRepository = $entityManager->getRepository(ExerciseType::class);
$exerciseTypeId = $exerciseTypeRepository->nextId();

$time = new Time(new \DateTime("2017-02-19 12:00:00", new DateTimeZone("utc")), new \DateTime("2016-03-28 13:00:00"), new DateTimeZone("utc"));
$workout = new Workout($workoutId, $time);

$exerciseType = new ExerciseType($exerciseTypeId, "Deadlift");

$entityManager->persist($workout);
$entityManager->persist($exerciseType);
$entityManager->flush();

$I->amOnPage("/workouts");

$I->click("19.02.2017");
$I->selectOption("Exercise", ["text" => "Deadlift"]);
$I->click("Add exercise");

$I->see("1. Deadlift");