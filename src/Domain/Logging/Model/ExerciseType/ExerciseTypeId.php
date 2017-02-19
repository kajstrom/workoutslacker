<?php
declare(strict_types=1);
namespace Domain\Logging\Model\ExerciseType;


class ExerciseTypeId
{
    /**
     * @var string
     */
    private $exerciseTypeId;

    public function __construct(string $id)
    {
        $this->exerciseTypeId = $id;
    }

    public function getExerciseTypeId() : string
    {
        return $this->exerciseTypeId;
    }
}