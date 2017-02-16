<?php
declare(strict_types=1);

namespace Domain\Logging\Model;

class Workout
{
    private $id;
    /**
     * @var \DateTime
     */
    private $date;


    public function __construct(\DateTimeImmutable $date)
    {
        $this->date = $date;
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
}