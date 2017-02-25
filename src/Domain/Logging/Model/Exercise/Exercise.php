<?php
declare(strict_types=1);

namespace Domain\Logging\Model\Exercise;


use Domain\Entity;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Domain\Logging\Model\Workout\WorkoutId;

class Exercise extends Entity
{
    /**
     * @var ExerciseId
     */
    private $exerciseId;
    /**
     * @var WorkoutId
     */
    private $workoutId;
    /**
     * @var ExerciseTypeId
     */
    private $exerciseTypeId;
    /**
     * @var int
     */
    private $nthInWorkout;

    /**
     * Exercise constructor.
     * @param ExerciseId $exerciseId
     * @param WorkoutId $workoutId
     * @param ExerciseTypeId $exerciseTypeId
     * @param int $nthInWorkout
     */
    public function __construct(ExerciseId $exerciseId, WorkoutId $workoutId, ExerciseTypeId $exerciseTypeId, int $nthInWorkout)
    {
        $this->workoutId = $workoutId;
        $this->exerciseTypeId = $exerciseTypeId;
        $this->nthInWorkout = $nthInWorkout;
        $this->exerciseId = $exerciseId;
    }
}