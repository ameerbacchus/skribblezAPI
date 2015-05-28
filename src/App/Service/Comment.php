<?php

namespace App\Service;

use App\Service;
use App\Entity\Comment as CommentEntity;
use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;

class Comment extends Service
{

    /**
     * Get a comment
     *
     * @param string $guid
     * @return CommentEntity
     */
    public function getComment($guid)
    {
        // @todo -- make custom repo and join user?
        return $this->getRepo()->findOneBy(['guid' => $guid]);
    }

    public function getComments($chapterGuid)
    {
        // @todo
    }

    /**
     * Creates a new comment and saves it to the database
     *
     * @todo -- test this
     *
     * @param ChapterEntity $chapter
     * @param UserEntity $user
     * @param string $body
     * @return CommentEntity
     */
    public function createComment(ChapterEntity $chapter, UserEntity $user, $body)
    {
        $newComment = new CommentEntity();
        $newComment
            ->setChapter($chapter)
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
     * @todo -- test this
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