<?php
/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 26.2.2017
 * Time: 16:23
 */

namespace Application;


use Adapters\Persistence\Doctrine\Logging\ExerciseRepository;
use Domain\Logging\Model\Exercise\Exercise;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Domain\Logging\Model\Workout\WorkoutId;

class WorkoutExerciseService
{
    /**
     * @var ExerciseRepository
     */
    private $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * Add an exercise to a workout.
     *
     * @param WorkoutId $workoutId
     * @param ExerciseTypeId $exerciseTypeId
     * @return Exercise
     */
    public function add(WorkoutId $workoutId, ExerciseTypeId $exerciseTypeId) : Exercise
    {
        $exerciseId = $this->exerciseRepository->nextId();
        $nthExerciseInWorkout = $this->exerciseRepository->exerciseCountForWorkout($workoutId) + 1;

        $exercise = new Exercise($exerciseId, $workoutId, $exerciseTypeId, $nthExerciseInWorkout);

        $this->exerciseRepository->save($exercise);

        return $exercise;
    }
}