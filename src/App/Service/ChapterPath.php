<?php
namespace App\Service;

use App\Service;
// use App\Entity\User as UserEntity;
use App\Entity\Chapter as ChapterEntity;
use App\Entity\ChapterPath as ChapterPathEntity;

class ChapterPath extends Base
{

    /**
     * Get a ChapterPath for a Chapter by GUID
     *
     * @param string $guid
     * @return ChapterPathEntity
     */
    public function getChapterPath($guid)
    {
        $repository = $this->getRepo();
        $cpath = $repository->findChapterPath($guid);

        return $cpath;
    }

    /**
     * Creates a new ChapterPath
     *
     * @param ChapterEntity $chapter
     * @return ChapterPathEntity
     */
    public function createChapterPath(ChapterEntity $chapter)
    {
        $prevChapter = $chapter->getPrev();
        $prevPath = $this->getChapterPath($prevChapter->getGuid());

        $pathGuids = [];
        if ($prevPath) {
            $pathGuids = $prevPath->getPathGuids();
        }
        $pathGuids[] = $prevChapter->getGuid();

        $newChapterPath = new ChapterPathEntity();
        $newChapterPath->setGuid($chapter->getGuid())
            ->setPathGuids($pathGuids);

        $em = $this->getEntityManager();
        $em->persist($newChapterPath);
        $em->flush();

        return $newChapterPath;
    }

    /**
     * Get and return the ChapterPath Repository
     *
     * @return App\Repository\ChapterPath
     */
    private function getRepo()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\ChapterPath');
        return $repository;
    }
}