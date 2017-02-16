<?php
declare(strict_types=1);

namespace Domain\Logging\Model;

use Domain\Entity;

class Workout extends Entity
{
    /** @var  WorkoutId */
    private $workoutId;
    /**
     * @var \DateTime
     */
    private $date;


    public function __construct(WorkoutId $workoutId, \DateTimeImmutable $date)
    {
        $this->date = $date;
        $this->workoutId = $workoutId;
    }
    
    /**
     * @param \DateTimeImmutable $date
     */
    public function setDate(\DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getId() : WorkoutId
    {
        return $this->workoutId;
    }
}