<?php

namespace App\Service;

use App\Service;
use App\Entity\Chapter as ChapterEntity;

class Chapter extends Service
{

    public function getChapter($id)
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\Chapter');
//         $chapter = $repository->find($id);
        $chapter = $repository->findOneBy(['guid' => $id]);

        return $chapter;
    }

}