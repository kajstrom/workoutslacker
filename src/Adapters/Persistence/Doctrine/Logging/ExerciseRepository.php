<?php
declare(strict_types=1);

namespace Adapters\Persistence\Doctrine\Logging;


use Adapters\Persistence\Doctrine\SaveEnabledRepository;
use Doctrine\ORM\EntityRepository;
use Domain\Logging\Model\Exercise\ExerciseId;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\WorkoutId;
use Ramsey\Uuid\Uuid;

class ExerciseRepository extends EntityRepository
{
    use SaveEnabledRepository;

    /**
     * Generate id.
     *
     * @return ExerciseId
     */
    public function nextId() : ExerciseId
    {
        return new ExerciseId(Uuid::uuid4()->toString());
    }

    /**
     * Find out exercises of a workout.
     *
     * @param WorkoutId $workoutId
     * @return array
     */
    public function findWorkoutExercises(WorkoutId $workoutId) : array
    {
        $query = $this->createQueryBuilder("e")
            ->select("e", "et")
            ->where("e.workoutId.workoutId = :id")
            ->setParameter("id", $workoutId->__toString())
            ->join(ExerciseType::class, 'et', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.exerciseTypeId.exerciseTypeId = et.exerciseTypeId.exerciseTypeId')
            ->orderBy("e.nthInWorkout", "ASC")
            ->getQuery();

        return $query->getScalarResult();
    }

    /**
     * Find out the current amount of exercises for the workout.
     *
     * @param WorkoutId $workoutId
     * @return int
     */
    public function exerciseCountForWorkout(WorkoutId $workoutId) : int
    {
        $qb = $this->createQueryBuilder("e");

        $query = $qb->select($qb->expr()->count("e"))
            ->where("e.workoutId.workoutId = :id")
            ->setParameter("id", $workoutId->__toString())
            ->getQuery();

        return (int)$query->getSingleResult()[1];
    }
}