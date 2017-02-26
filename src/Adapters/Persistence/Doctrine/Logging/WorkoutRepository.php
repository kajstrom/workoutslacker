<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 16.2.2017
 * Time: 21:43
 */

namespace Adapters\Persistence\Doctrine\Logging;


use Doctrine\ORM\EntityRepository;
use Domain\Logging\Model\Workout\Workout;
use Domain\Logging\Model\Workout\WorkoutId;
use Ramsey\Uuid\Uuid;

class WorkoutRepository extends EntityRepository
{
    public function nextId() : WorkoutId
    {
        return new WorkoutId(Uuid::uuid4()->toString());
    }

    public function findByWorkoutId(WorkoutId $workoutId) : Workout
    {
        $query = $this->createQueryBuilder("w")
            ->where("w.workoutId.workoutId = :id")
            ->setParameter("id", $workoutId->__toString())
            ->getQuery();

        return $query->getSingleResult();
    }
}