<?php
/**
 * Created by PhpStorm.
 * User: Kaitsu
 * Date: 16.2.2017
 * Time: 21:43
 */

namespace Domain\Logging\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\EntityRepository;
use Domain\Logging\Model\WorkoutId;
use Ramsey\Uuid\Uuid;

class WorkoutRepository extends EntityRepository
{
    public function nextId() : WorkoutId
    {
        return new WorkoutId(Uuid::uuid4());
    }
}