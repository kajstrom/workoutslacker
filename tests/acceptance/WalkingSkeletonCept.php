<?php
use Codeception\Util\Fixtures;
use Domain\Logging\Model\Workout;

$I = new AcceptanceTester($scenario);
$I->wantTo('start the test cycle');

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = Fixtures::get("entityManager");

$workout = new Workout(new \DateTimeImmutable("2016-03-28"));

$entityManager->persist($workout);
$entityManager->flush();

$I->amOnPage("/workouts");
$I->see("28.03.2016");
