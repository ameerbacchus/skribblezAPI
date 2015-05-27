<?php

namespace App\Resource;

use App\Resource;
use App\Service\Chapter as ChapterService;

class Chapter extends Resource
{
    /**
     * @var \App\Service\Chapter
     */
    private $chapterService;

    /**
     * Get user service
     */
    public function init()
    {
        $this->setChapterService(new ChapterService($this->getEntityManager()));
    }

    /**
     * Get Chapter
     *
     * @param string $guid
     */
    public function get($guid = null)
    {
        if ($guid === null) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        $chapter = $this->chapterService->getChapter($guid);

        if ($chapter === null) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        self::response(self::STATUS_OK, ['chapter' => $chapter]);
    }

    /**
     * Create user
     */
//     public function post()
//     {
//         $email = $this->getSlim()->request()->params('email');
//         $password = $this->getSlim()->request()->params('password');

//         if (empty($email) || empty($password) || $email === null || $password === null) {
//             self::response(self::STATUS_BAD_REQUEST);
//             return;
//         }

//         $user = $this->getUserService()->createUser($email, $password);

//         self::response(self::STATUS_CREATED, array('user', $user));
//     }

    /**
     * Update user
     */
//     public function put($id)
//     {
//         $email = $this->getSlim()->request()->params('email');
//         $password = $this->getSlim()->request()->params('password');

//         if (empty($email) && empty($password) || $email === null && $password === null) {
//             self::response(self::STATUS_BAD_REQUEST);
//             return;
//         }

//         $user = $this->getUserService()->updateUser($id, $email, $password);

//         if ($user === null) {
//             self::response(self::STATUS_NOT_IMPLEMENTED);
//             return;
//         }

//         self::response(self::STATUS_NO_CONTENT);
//     }

    /**
     * @param $id
     */
//     public function delete($id)
//     {
//         $status = $this->getUserService()->deleteUser($id);

//         if ($status === false) {
//             self::response(self::STATUS_NOT_FOUND);
//             return;
//         }

//         self::response(self::STATUS_OK);
//     }

    /**
     * Show options in header
     */
    public function options()
    {
        self::response(self::STATUS_OK, array(), array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'));
    }

//     /**
//      * @return \App\Service\User
//      */
//     public function getUserService()
//     {
//         return $this->userService;
//     }

//     /**
//      * @param \App\Service\User $userService
//      */
//     public function setUserService($userService)
//     {
//         $this->userService = $userService;
//     }

    /**
     * [Setter]
     *
     * @param \App\Service\Chapter $chapterService
     * @return User
     */
    public function setChapterService($chapterService)
    {
        $this->chapterService = $chapterService;
        return $this;
    }

    /**
     * @return \App\Service\Chapter
     */
    public function getChapterService()
    {
        return $this->chapterService;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}