<?php
namespace App\Service;

use App\Service;
use App\Entity\Comment as CommentEntity;
use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;

class Comment extends Base
{

    /**
     * Get a comment
     *
     * @param string $guid
     * @return CommentEntity
     */
    public function getComment($guid)
    {
        return $this->getRepo()->findComment($guid);
    }

    /**
     * Get comments for a chapter
     *
     * @param string $chapterGuid
     */
    public function getComments($chapterGuid)
    {
        return $this->getRepo()->findComments($chapterGuid);
    }

    /**
     * Creates a new comment and saves it to the database
     *
     * @param ChapterEntity $chapter
     * @param UserEntity $user
     * @param string $body
     * @return CommentEntity
     */
    public function createComment(ChapterEntity $chapter, UserEntity $user, $body)
    {
        $newComment = new CommentEntity();
        $newComment->setChapter($chapter)
            ->setUser($user)
            ->setBody($body);

        $em = $this->getEntityManager();
        $em->persist($newComment);
        $em->flush();

        return $newComment;
    }

    /**
     * Updates a comment and saves it to the database
     *
     * @param CommentEntity $comment
     * @param string $body
     * @return CommentEntity
     */
    public function updateComment(CommentEntity $comment, $body)
    {
        $comment->setBody($body);

        $em = $this->getEntityManager();
        $em->persist($comment);
        $em->flush();

        return $comment;
    }

    /**
     * Get and return the Chapter Repository
     *
     * @return App\Repository\Chapter
     */
    private function getRepo()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Comment');
        return $repository;
    }
}