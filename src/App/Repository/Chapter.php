<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class Chapter extends EntityRepository
{
    public function findChapter($guid)
    {
        $query = $this->_em->createQuery('
            SELECT c, a
            FROM App\Entity\Chapter c
            LEFT JOIN c.author a
            WHERE c.guid = :guid
        ');

        $query->setParameter('guid', $guid);

        return $query->getOneOrNullResult();
    }
}

