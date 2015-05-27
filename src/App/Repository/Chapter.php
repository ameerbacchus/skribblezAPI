<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class Chapter extends EntityRepository
{
    public function findChapter($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, a
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                WHERE c.guid = :guid
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }
}

