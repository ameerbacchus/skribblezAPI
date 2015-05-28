<?php

namespace App\Service;

use App\Service;
use App\Entity\User as UserEntity;

class User extends Base
{
    /**
     * Get a single user by GUID
     *
     * @param string $guid
     * @return UserEntity
     */
    public function getUser($guid)
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\User');
        $user = $repository->findOneBy(['guid' => $guid]);

        return $user;
    }

}