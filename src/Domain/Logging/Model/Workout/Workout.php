<?php
declare(strict_types=1);

namespace Domain\Logging\Model\Workout;

use Domain\Entity;

class Workout extends Entity
{
    /** @var  WorkoutId */
    private $workoutId;
    /**
     * @var Time
     */
    private $time;


    public function __construct(WorkoutId $workoutId, Time $time)
    {
        $this->workoutId = $workoutId;
        $this->time = $time;
    }

    /**
     * @return Time
     */
    public function getTime() : Time
    {
        return $this->time;
    }

    public function getId() : WorkoutId
    {
        return $this->workoutId;
    }
}