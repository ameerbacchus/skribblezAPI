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
     * >
     */
    public function findChapter($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, a, prev, par
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                LEFT JOIN c.prev prev
                LEFT JOIN c.parent par
                WHERE c.guid = :guid
                AND c.deleted = 0
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }

    /**
     * Queries for Chapters by an array of GUIDs
     *
     * @param array<string> $guids
     * @return Ambigous <
     * 		multitype:,
     * 		\Doctrine\ORM\mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * >
     */
    public function findChapters($guids)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, a
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                WHERE c.guid IN (:guids)
                AND c.deleted = 0
                ORDER BY c.sequence ASC
            ')
            ->setParameter('guids', $guids);

        return $q->getResult();
    }

    /**
     * Queries for all of the chapters in the next sequence for the given id (integer $id, not guid)
     *
     * @param string $guid
     * @return Ambigous <
     * 		multitype:,
     * 		\Doctrine\ORM\mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * >
     */
    public function findNextChapters($guid, $offset = 0, $limit = 20)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, a, p
                FROM App\Entity\Chapter c
                LEFT JOIN c.author a
                LEFT JOIN c.prev p
                WHERE p.guid = :guid
                AND c.deleted = 0
                ORDER BY c.created ASC
            ')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('guid', $guid);

        return $q->getResult();
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
     * >
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
                ORDER BY c.created DESC
            ')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $q->getResult();
    }
}

