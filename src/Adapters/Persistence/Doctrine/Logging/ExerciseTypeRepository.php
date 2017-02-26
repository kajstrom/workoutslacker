<?php
declare(strict_types=1);

namespace Adapters\Persistence\Doctrine\Logging;


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