<?php
declare(strict_types=1);

namespace Domain\Logging\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\EntityRepository;
use Domain\Logging\Model\ExerciseType\ExerciseTypeId;
use Ramsey\Uuid\Uuid;

class ExerciseTypeRepository extends EntityRepository
{
    public function nextId() : ExerciseTypeId
    {
        return new ExerciseTypeId(Uuid::uuid4()->toString());
    }
}