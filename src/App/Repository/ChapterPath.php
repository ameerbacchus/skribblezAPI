<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ChapterPath extends EntityRepository
{
    /**
     * Queries for a ChapterPath
     * @param string $guid
     * @return Ambigous <
     * 		\Doctrine\ORM\mixed,
     * 		NULL,
     * 		mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * >
     */
    public function findChapterPath($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT cp
                FROM App\Entity\ChapterPath cp
                WHERE cp.guid = :guid
                AND cp.deleted = 0
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }
}

