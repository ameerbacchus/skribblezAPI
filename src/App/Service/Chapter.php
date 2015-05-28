<?php

namespace App\Service;

use App\Service;
use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;

class Chapter extends Service
{
    /**
     * Get the starter chapters
     *
     * @param number $page
     * @return array
     */
    public function getStarters($page = 1)
    {
        $pageSize = 10;
        $offset = $pageSize * ($page - 1);

        $repository = $this->getRepo();
        $starters = $repository->findStarters($offset, $pageSize);

        return $starters;
    }

    /**
     * Gets a single chapter by GUID
     *
     * @param string $guid
     * @return ChapterEntity
     */
    public function getChapter($guid)
    {
        $repository = $this->getRepo();
        $chapter = $repository->findChapter($guid);

        return $chapter;
    }

    /**
     * Gets the following sequence of chapters, given a GUID
     *
     * @param integer $id
     * @return array<ChapterEntity>
     */
    public function getNextChapters($id)
    {
        $repository = $this->getRepo();
        $chapters = $repository->findNextChapters($id);

        return $chapters;
    }

    /**
     * Create a new chapter and save it to the database
     *
     * @param UserEntity $author
     * @param string $body
     * @param integer $sequence
     * @param string $title
     * @param ChapterEntity $prevChapter
     * @param ChapterEntity $parentChapter
     * @return ChapterEntity
     */
    public function createChapter(UserEntity $author, $body, $sequence = 1, $title = null, ChapterEntity $prevChapter = null, ChapterEntity $parentChapter = null)
    {
        $newChapter = new ChapterEntity();
        $newChapter
            ->setAuthor($author)
            ->setBody($body)
            ->setSequence($sequence)
            ->setTitle($title)
            ->setPrev($prevChapter)
            ->setParent($parentChapter);

        $em = $this->getEntityManager();
        $em->persist($newChapter);
        $em->flush();

        return $newChapter;
    }

    /**
     * Get and return the Chapter Repository
     *
     * @return App\Repository\Chapter
     */
    private function getRepo()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Chapter');
        return $repository;
    }
}