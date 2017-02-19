<?php

use Domain\Logging\Infrastructure\Persistence\Doctrine\ExerciseTypeRepository;
use Domain\Logging\Model\ExerciseType\ExerciseType;

require_once dirname(__FILE__) . "/../bootstrap.php";

/** @var ExerciseTypeRepository $exerciseTypeRepository */
$exerciseTypeRepository = $entityManager->getRepository(ExerciseType::class);

$exerciseTypeId = $exerciseTypeRepository->nextId();

$exerciseType = new ExerciseType($exerciseTypeId, $argv[1]);

$entityManager->persist($exerciseType);
$entityManager->flush();