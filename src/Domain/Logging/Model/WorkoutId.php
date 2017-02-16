<?php
declare(strict_types=1);

namespace Domain\Logging\Model;


class WorkoutId
{
    /**
     * @var string
     */
    private $workoutId;

    public function __construct(string $workoutId)
    {
        $this->workoutId = $workoutId;
    }

    public function __toString()
    {
        return $this->workoutId;
    }
}