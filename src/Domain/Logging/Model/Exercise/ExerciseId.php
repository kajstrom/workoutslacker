<?php
declare(strict_types=1);

namespace Domain\Logging\Model\Exercise;


class ExerciseId
{
    /**
     * @var string
     */
    private $exerciseId;

    public function __construct(string $exerciseId)
    {
        $this->exerciseId = $exerciseId;
    }

    public function __toString()
    {
        return $this->exerciseId;
    }
}