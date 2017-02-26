<?php
declare(strict_types=1);

namespace Adapters\Persistence\Doctrine;

use Domain\Entity;

trait SaveEnabledRepository
{
    public function save(Entity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}