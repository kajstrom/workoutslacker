<?php
declare(strict_types=1);

namespace Application;


use Adapters\Persistence\Doctrine\Logging\ExerciseRepository;
use Codeception\Util\Stub;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Domain\Logging\Model\Workout\WorkoutId;

class WorkoutExerciseServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function makeWorkoutExerciseService($exerciseRepositoryMethods = []) : WorkoutExerciseService
    {
        $exerciseRepository = Stub::makeEmpty(ExerciseRepository::class, $exerciseRepositoryMethods, $this);
        return new WorkoutExerciseService($exerciseRepository);
    }

    // tests
    public function testAdd_WhenCalled_CallsSaveOnExerciseRepository()
    {
        $repositoryMethods = [
            "save" => Stub::once()
        ];

        $workoutExerciseService = $this->makeWorkoutExerciseService($repositoryMethods);

        $workoutExerciseService->add(new WorkoutId("asd123"), new ExerciseTypeId("weasd232"));
    }
}