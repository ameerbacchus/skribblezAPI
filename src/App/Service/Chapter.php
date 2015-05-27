<?php

namespace App\Service;

use App\Service;
use App\Entity\Chapter as ChapterEntity;

class Chapter extends Service
{

    /**
     * Get a single chapter by GUID
     *
     * @param string $guid
     * @return ChapterEntity
     */
    public function getChapter($guid)
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Chapter');
        $chapter = $repository->findChapter($guid);

        return $chapter;
    }

}