<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class Chapter extends EntityRepository
{
    /**
     * Queries for a Chapter
     *
     * @param string $guid
     * @return Ambigous <
     * 		\Doctrine\ORM\mixed,
     * 		NULL,
     * 		mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * 	>
     */
    public function findChapter($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, prev, par
                FROM App\Entity\Chapter c
                LEFT JOIN c.prev prev
                LEFT JOIN c.parent par
                WHERE c.guid = :guid
                AND c.deleted = 0
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }

    /**
     * Queries for a Chapter, with details
     *
     * @todo -- get next level of chapters
     *
     * @param string $guid
     * @return Ambigous <
     * 		\Doctrine\ORM\mixed,
     * 		NULL,
     * 		mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * 	>
     */
    public function findChapterDetails($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, a
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                WHERE c.guid = :guid
                AND c.deleted = 0
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }

    /**
     * Query for starter chapters
     *
     * @param int $offset
     * @param int $limit
     *
     * @return Ambigous <
     * 		multitype:,
     * 		\Doctrine\ORM\mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * 	>
     */
    public function findStarters($offset = 0, $limit = 10)
    {
        $em = $this->getEntityManager();
        $q = $em->
                createQuery('
                SELECT c, a
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                WHERE c.sequence = 1
                AND c.deleted = 0
            ')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $q->getResult();
    }
}

