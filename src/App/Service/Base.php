<?php

namespace App\Service;

use App\Service;
use App\Entity\Base as BaseEntity;

class Base extends Service
{
    /**
     * Marks an entity as deleted
     *
     * @param BaseEntity $entity
     * @return BaseEntity
     */
    public function delete(BaseEntity $entity)
    {
        $entity->setDeleted(true);

        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $entity;
    }
}