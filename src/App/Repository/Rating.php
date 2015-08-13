<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class Rating extends EntityRepository
{

    /**
     * Queries for a single rating
     *
     * @param string $guid
     * @return Ambigous <
     *         \Doctrine\ORM\mixed,
     *         NULL,
     *         mixed,
     *         \Doctrine\ORM\Internal\Hydration\mixed,
     *         \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed
     *         >
     */
    public function findRating($guid)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('
                SELECT r, u
                FROM App\Entity\Rating r
                LEFT JOIN r.user u
                WHERE r.guid = :guid
                AND r.deleted = 0
            ')->setParameter('guid', $guid);

        return $q->getOneOrNullResult();
    }

    /**
     * Queries for Ratings for a Chapter
     *
     * @param string $chapterGuid
     * @return Ambigous <
     *         multitype:,
     *         \Doctrine\ORM\mixed,
     *         \Doctrine\ORM\Internal\Hydration\mixed,
     *         \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed
     *         >
     */
    public function findRatings($chapterGuid, $offset = 0, $limit = 40)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('
                SELECT r, u, c
                FROM App\Entity\Rating
                LEFT JOIN r.user u
                LEFT JOIN r.chapter c
                WHERE c.guid = :guid
                AND r.deleted = 0
            ')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('cguid', $chapterGuid);

        return $q->getResult();
    }

    /**
     *
     * Queries for a user's rating for a chapter
     *
     * @param string $chapterGuid
     * @param string $userGuid
     * @return Ambigous <
     *         \Doctrine\ORM\mixed,
     *         NULL,
     *         mixed,
     *         \Doctrine\ORM\Internal\Hydration\mixed,
     *         \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed
     *         >
     */
    public function findUserRating($chapterGuid, $userGuid)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery('
                SELECT r, c, u
                FROM App\Entity\Rating r
                LEFT JOIN r.chapter c
                LEFT JOIN r.user u
                WHERE c.guid = :cguid
                AND u.guid = :uguid
                AND r.deleted = 0
            ')
            ->setParameter('cguid', $chapterGuid)
            ->setParameter('uguid', $userGuid);

        return $q->getOneOrNullResult();
    }

    /**
     * Query for the average rating and number of ratings for a chapter
     *
     * @param string $chapterGuid
     * @return array
     */
    public function findRatingData($chapterGuid)
    {
        $sql = '
            SELECT
                AVG(ratings.score) as avgScore,
                COUNT(*) as ratingCount,
                chapters._id
            FROM ratings
            LEFT JOIN chapters
                ON ratings.chapter_id = chapters._id
            WHERE chapters._guid = :guid
        ';

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('avgScore', 'score')->addScalarResult('ratingCount', 'count');

        $em = $this->getEntityManager();
        $q = $em->createNativeQuery($sql, $rsm)->setParameter('guid', $chapterGuid);

        return $q->getOneOrNullResult();
    }
}

