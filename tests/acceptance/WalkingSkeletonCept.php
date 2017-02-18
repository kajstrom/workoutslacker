<?php
use Codeception\Util\Fixtures;
use Domain\Logging\Infrastructure\Persistence\Doctrine\WorkoutRepository;
use Domain\Logging\Model\Workout\Time;
use Domain\Logging\Model\Workout\Workout;

$I = new AcceptanceTester($scenario);
$I->wantTo('start the test cycle');

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = Fixtures::get("entityManager");
/** @var WorkoutRepository $workoutRepository */
$workoutRepository = $entityManager->getRepository(Workout::class);

$workoutId = $workoutRepository->nextId();

$time = new Time(new \DateTime("2016-03-28 12:00:00", new DateTimeZone("utc")), new \DateTime("2016-03-28 13:00:00"), new DateTimeZone("utc"));
$workout = new Workout($workoutId, $time);

$entityManager->persist($workout);
$entityManager->flush();

$I->amOnPage("/workouts");
$I->see("28.03.2016");
