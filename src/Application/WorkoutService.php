<?php
declare(strict_types=1);

namespace Application;


use Adapters\Persistence\Doctrine\Logging\ExerciseRepository;
use Adapters\Persistence\Doctrine\Logging\ExerciseTypeRepository;
use Adapters\Persistence\Doctrine\Logging\WorkoutRepository;
use Domain\Logging\Model\ExerciseType\ExerciseType;
use Domain\Logging\Model\Workout\Time;
use Domain\Logging\Model\Workout\Workout;
use Domain\Logging\Model\Workout\WorkoutId;

class WorkoutService
{
    /**
     * @var WorkoutRepository
     */
    private $workoutRepository;
    /**
     * @var ExerciseTypeRepository
     */
    private $exerciseTypeRepository;
    /**
     * @var ExerciseRepository
     */
    private $exerciseRepository;

    public function __construct(WorkoutRepository $workoutRepository, ExerciseTypeRepository $exerciseTypeRepository, ExerciseRepository $exerciseRepository)
    {
        $this->workoutRepository = $workoutRepository;
        $this->exerciseTypeRepository = $exerciseTypeRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * Retrieve all workouts.
     *
     * @return Workout[]
     */
    public function all() : array
    {
        return $this->workoutRepository->findAll();
    }

    /**
     * Add a new workout.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Workout
     */
    public function add(\DateTime $start, \DateTime $end) : Workout
    {
        if ($end < $start) {
            $end->add(new \DateInterval("P1D"));
        }

        $time = new Time($start, $end);

        $workoutId = $this->workoutRepository->nextId();

        $workout = new Workout($workoutId, $time);

        $this->workoutRepository->save($workout);

        return $workout;
    }

    /**
     * Gather information required for showing a workout.
     *
     * @param WorkoutId $workoutId
     * @return array
     */
    public function show(WorkoutId $workoutId) : array
    {
        $workout = $this->workoutRepository->findByWorkoutId($workoutId);
        /** @var ExerciseType[] $exerciseTypes */
        $exerciseTypes = $this->exerciseTypeRepository->findBy([], ["name" => "ASC"]);
        $workoutExercises = $this->exerciseRepository->findWorkoutExercises($workoutId);

        $exerciseTypeArray = [];
        foreach ($exerciseTypes as $exerciseType) {
            $exerciseTypeArray[] = [
                "name" => $exerciseType->getName(),
                "exerciseTypeId" => $exerciseType->getExerciseTypeId()->getExerciseTypeId()
            ];
        }

        return [
            "workout" => $workout,
            "exercises" => $workoutExercises,
            "exerciseTypes" => $exerciseTypeArray
        ];
    }
}