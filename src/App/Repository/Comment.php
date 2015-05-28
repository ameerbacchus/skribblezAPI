<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class Comment extends EntityRepository
{
    /**
     * Queries for a Comment
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
    public function findComment($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, u
                FROM App\Entity\Comment c
                LEFT JOIN c.user u
                WHERE c.guid = :guid
                AND c.deleted = 0
            ')
            ->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }

    /**
     * Queries for Comments for a Chapter
     *
     * @param string $chapterGuid
     * @return Ambigous <
     * 		multitype:,
     * 		\Doctrine\ORM\mixed,
     * 		\Doctrine\ORM\Internal\Hydration\mixed,
     * 		\Doctrine\DBAL\Driver\Statement,
     * 		\Doctrine\Common\Cache\mixed
     * >
     */
    public function findComments($chapterGuid, $offset = 0, $limit = 40)
    {
        $em = $this->getEntityManager();
        $q = $em->
            createQuery('
                SELECT c, ch, u
                FROM App\Entity\Comment c
                LEFT JOIN c.user u
                LEFT JOIN c.chapter ch
                WHERE ch.guid = :cguid
                AND c.deleted = 0
                ORDER BY c.created ASC
            ')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('cguid', $chapterGuid);

        return $q->getResult();
    }
}

