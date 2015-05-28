<?php

namespace App\Resource;

use App\Resource;
use App\Service\Chapter as ChapterService;
use App\Service\User as UserService;

class Chapter extends Resource
{
    /**
     * @var ChapterService
     */
    private $chapterService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * Get user service
     */
    public function init()
    {
        $this->setChapterService(new ChapterService($this->getEntityManager()));
        $this->setUserService(new UserService($this->getEntityManager()));
    }

    /**
     * Get starter chapters
     *
     * @param integer $page
     */
    public function getStarters($page = 1)
    {
        $starters = $this->chapterService->getStarters($page);
        self::response(self::STATUS_OK, ['starters' => $starters]);
    }

    /**
     * Get Chapter
     *
     * @param string $guid
     */
    public function getChapter($guid)
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

        $nextChapters = $this->chapterService->getNextChapters($chapter->getId());

        $response = [
            'chapter' => $chapter,
            'next' => $nextChapters
        ];

        self::response(self::STATUS_OK, $response);
    }

    /**
     * Post a new starter chapter
     */
    public function postStarter()
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $authorGuid = $request->params('author');
        $author = $this->getUserService()->getUser($authorGuid);
        $title = $request->params('title');
        $body = $request->params('body');

        $newStarter = $this->getChapterService()->createChapter($author, $body, 1, $title);

        self::response(self::STATUS_OK, ['starter' => $newStarter]);
    }

    /**
     * Post a new chapter
     */
    public function postChapter()
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $authorGuid = $request->params('author');
        $author = $this->getUserService()->getUser($authorGuid);
        $body = $request->params('body');
        $prevChapter = $this->getChapterService()->getChapter($request->params('prevChapter'));
        $parentChapter = $prevChapter->getSequence() === 1 ? $prevChapter : $prevChapter->getParent();
        $sequence = $prevChapter->getSequence() + 1;

        $newChapter = $this->getChapterService()->createChapter($author, $body, $sequence, null, $prevChapter, $parentChapter);

        // @todo -- create path entry (table pending)

        self::response(self::STATUS_OK, ['chapter' => $newChapter]);
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

    /**
     * [Setter]
     *
     * @param ChapterService $chapterService
     * @return Chapter
     */
    public function setChapterService($chapterService)
    {
        $this->chapterService = $chapterService;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return ChapterService
     */
    public function getChapterService()
    {
        return $this->chapterService;
    }

    /**
     * [Setter]
     *
     * @param UserService $userService
     * @return Chapter
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return UserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}