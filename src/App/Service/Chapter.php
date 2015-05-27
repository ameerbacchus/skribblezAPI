<?php

namespace App\Service;

use App\Service;
use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;

class Chapter extends Service
{

    /**
     * Gets a single chapter by GUID
     *
     * @param string $guid
     * @return ChapterEntity
     */
    public function getChapter($guid)
    {
        $repository = $this->_getRepo();
//         $chapter = $repository->findOneBy(['guid' => $guid]);
        $chapter = $repository->findChapter($guid);

        return $chapter;
    }

    /**
     * Get a single chapter, with details, by GUID
     *
     * @param string $guid
     * @return ChapterEntity
     */
    public function getChapterDetails($guid)
    {
        $repository = $this->_getRepo();
        $chapter = $repository->findChapterDetails($guid);

        return $chapter;
    }

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

        $repository = $this->_getRepo();
        $starters = $repository->findStarters($offset, $pageSize);

        return $starters;
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
    private function _getRepo()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Chapter');
        return $repository;
    }
}