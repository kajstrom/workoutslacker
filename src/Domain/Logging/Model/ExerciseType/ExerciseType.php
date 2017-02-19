<?php
declare(strict_types=1);

namespace Domain\Logging\Model\ExerciseType;


use Domain\Entity;

class ExerciseType extends Entity
{
    /**
     * @var ExerciseTypeId
     */
    private $exerciseTypeId;
    /**
     * @var string
     */
    private $name;

    public function __construct(ExerciseTypeId $exerciseTypeId, string $name)
    {
        $this->exerciseTypeId = $exerciseTypeId;
        $this->name = $name;
    }

    /**
     * @return ExerciseTypeId
     */
    public function getExerciseTypeId(): ExerciseTypeId
    {
        return $this->exerciseTypeId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}