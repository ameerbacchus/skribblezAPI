<?php

namespace App\Resource;

use App\Resource;
use App\Service\Chapter as ChapterService;
use App\Service\ChapterPath as ChapterPathService;
use App\Service\User as UserService;
use App\Service\Comment as CommentService;
use App\Service\Rating as RatingService;

class Chapter extends Resource
{
    /**
     * @var ChapterService
     */
    private $chapterService;

    /**
     * @var ChapterPathService
     */
    private $chapterPathService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * @var RatingService
     */
    private $ratingService;

    /**
     * Get user service
     */
    public function init()
    {
        $this->setChapterService(new ChapterService($this->getEntityManager()));
        $this->setChapterPathService(new ChapterPathService($this->getEntityManager()));
        $this->setUserService(new UserService($this->getEntityManager()));
        $this->setCommentService(new CommentService($this->getEntityManager()));
        $this->setRatingService(new RatingService($this->getEntityManager()));
    }

    /**
     * Get starter chapters
     *
     * @param integer $page
     */
    public function getStarters($page = 1)
    {
        $starters = $this->getChapterService()->getStarters($page);
        self::response(self::STATUS_OK, ['starters' => $starters]);
    }

    /**
     * Get Chapter
     *
     * @todo -- get logged in user
     *
     * @param string $guid
     */
    public function getChapter($guid)
    {
        if ($guid === null) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        $chapter = $this->getChapterService()->getChapter($guid);

        if ($chapter === null) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        $nextChapters = $this->getChapterService()->getNextChapters($guid);
        $comments = $this->getCommentService()->getComments($guid);

        $userRating = null;
        $user = $this->getUserService()->getUser('author1');	// @todo -- get logged in user
        if ($user) {
            $userRating = $this->getRatingService()->getUserRating($chapter, $user);
        }

        $ratingData = $this->getRatingService()->getRatingData($chapter);

        $response = [
            'chapter' => $chapter,
            'next' => $nextChapters,
            'comments' => $comments,
            'userRating' => $userRating,
            'rating' => $ratingData
        ];

        self::response(self::STATUS_OK, $response);
    }

    /**
     * Post a new starter chapter
     *
     * @todo -- auth check
     */
    public function postStarter()
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $authorGuid = $request->params('author');	// @todo -- get logged in user
        $author = $this->getUserService()->getUser($authorGuid);

        $title = $request->params('title');
        $body = $request->params('body');

        $newStarter = $this->getChapterService()->createChapter($author, $body, 1, $title);

        self::response(self::STATUS_CREATED, ['starter' => $newStarter]);
    }

    /**
     * Post a new chapter
     *
     * @todo -- auth check
     */
    public function postChapter($prevGuid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $authorGuid = $request->params('author');	// @todo -- get logged in user
        $author = $this->getUserService()->getUser($authorGuid);

        $body = $request->params('body');
        $prevChapter = $this->getChapterService()->getChapter($prevGuid);
        $parentChapter = $prevChapter->isStarter() ? $prevChapter : $prevChapter->getParent();
        $sequence = $prevChapter->getSequence() + 1;

        $newChapter = $this->getChapterService()->createChapter($author, $body, $sequence, null, $prevChapter, $parentChapter);

        $newChapterPath = $this->getChapterPathService()->createChapterPath($newChapter);

        self::response(self::STATUS_CREATED, ['chapter' => $newChapter]);
    }

    /**
     * Updates a chapter
     *
     * @todo -- auth check
     *
     * @param string $guid
     */
    public function patchChapter($guid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $body = $request->params('body');
        $title = $request->params('title');

        $chapter = $this->getChapterService()->getChapter($guid);
        $chapter = $this->getChapterService()->updateChapter($chapter, $body, $title);

        self::response(self::STATUS_OK, ['chapter' => $chapter]);
    }

    /**
     * Deletes a chapter
     *
     * @todo -- auth check
     *
     * @param string $guid
     */
    public function deleteChapter($guid)
    {
        $chapter = $this->getChapterService()->getChapter($guid);
        if ($chapter) {
            $this->getChapterService()->delete($chapter);
        }

        self::response(self::STATUS_NO_CONTENT);
    }

    /**
     * Gets all of the chapters that led up to (and including) the requested chapter
     *
     * @param string $guid
     */
    public function getChapterPath($guid)
    {
        $chapterPath = $this->getChapterPathService()->getChapterPath($guid);
        $guids = $chapterPath->getPathGuids();
        $guids[] = $guid;

        $chapters = $this->getChapterService()->getChapters($guids);

        self::response(self::STATUS_OK, ['path' => $chapters]);
    }

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
     * @param ChapterPathService $chapterPathService
     * @return Chapter
     */
    public function setChapterPathService($chapterPathService)
    {
        $this->chapterPathService = $chapterPathService;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return ChapterPath
     */
    public function getChapterPathService()
    {
        return $this->chapterPathService;
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
     * [Setter]
     *
     * @param CommentService $commentService
     * @return Chapter
     */
    public function setCommentService($commentService)
    {
        $this->commentService = $commentService;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return CommentService
     */
    public function getCommentService()
    {
        return $this->commentService;
    }

    /**
     * [Setter]
     *
     * @param RatingService $ratingService
     * @return Chapter
     */
    public function setRatingService($ratingService)
    {
        $this->ratingService = $ratingService;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return RatingService
     */
    public function getRatingService()
    {
        return $this->ratingService;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}