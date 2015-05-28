<?php

namespace App\Service;

use App\Service;
use App\Entity\Rating as RatingEntity;
use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;

class Rating extends Base
{
    /**
     * Gets a user's rating for a chapter
     *
     * @param string $chapterGuid
     * @return RatingEntity
     */
    public function getUserRating(ChapterEntity $chapter, UserEntity $user)
    {
        $repository = $this->getRepo();
        $rating = $repository->findUserRating($chapter->getGuid(), $user->getGuid());
        return $rating;
    }

    /**
     * Creates a new rating and saves it to the database
     *
     * @param ChapterEntity $chapter
     * @param UserEntity $user
     * @param integer $score
     * @return RatingEntity
     */
    public function createRating(ChapterEntity $chapter, UserEntity $user, $score)
    {
        $newRating = new RatingEntity();
        $newRating
            ->setChapter($chapter)
            ->setUser($user)
            ->setScore($score);

        $em = $this->getEntityManager();
        $em->persist($newRating);
        $em->flush();

        return $newRating;
    }

    /**
     * Updates a rating and saves it to the database
     *
     * @param RatingEntity $comment
     * @param integer $score
     * @return RatingEntity
     */
    public function updateRating(RatingEntity $rating, $score)
    {
        $rating->setScore($score);

        $em = $this->getEntityManager();
        $em->persist($rating);
        $em->flush();

        return $rating;
    }

    /**
     * Get and return the Chapter Repository
     *
     * @return App\Repository\Chapter
     */
    private function getRepo()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Rating');
        return $repository;
    }
}