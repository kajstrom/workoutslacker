<?php
declare(strict_types=1);

namespace Domain\Logging\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\EntityRepository;
use Domain\Logging\Model\Exercise\ExerciseId;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\WorkoutId;
use Ramsey\Uuid\Uuid;

class ExerciseRepository extends EntityRepository
{
    public function nextId() : ExerciseId
    {
        return new ExerciseId(Uuid::uuid4()->toString());
    }

    public function findWorkoutExercises(WorkoutId $workoutId) : array
    {
        $query = $this->createQueryBuilder("e")
            ->select("e", "et")
            ->where("e.workoutId.workoutId = :id")
            ->setParameter("id", $workoutId->__toString())
            ->join(ExerciseType::class, 'et', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.exerciseTypeId.exerciseTypeId = et.exerciseTypeId.exerciseTypeId')
            ->orderBy("e.nthInWorkout", "DESC")
            ->getQuery();

        return $query->getScalarResult();
    }
}