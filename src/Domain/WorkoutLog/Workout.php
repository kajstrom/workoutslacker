<?php
namespace Domain\WorkoutLog;

class Workout
{
    protected $id;
    /**
     * @var \DateTime
     */
    protected $date;

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
}