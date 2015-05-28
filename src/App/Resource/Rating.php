<?php

namespace App\Resource;

use App\Resource;
use App\Service\Rating as RatingService;
use App\Service\Chapter as ChapterService;
use App\Service\User as UserService;

class Rating extends Resource
{
    /**
     * @var \App\Service\Rating
     */
    private $ratingService;

    /**
     * Init
     */
    public function init()
    {
        $this->setRatingService(new RatingService($this->getEntityManager()));
        $this->setChapterService(new ChapterService($this->getEntityManager()));
        $this->setUserService(new UserService($this->getEntityManager()));
    }

    /**
     * Post a new rating
     *
     * @param string $chapterGuid
     */
    public function postRating($chapterGuid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();

        $score = $request->params('score');
        $user = $this->getUserService()->getUser($request->params('user'));
        $chapter = $this->getChapterService()->getChapter($chapterGuid);

        $newRating = $this->getRatingService()->createRating($chapter, $user, $score);

        self::response(self::STATUS_CREATED, ['rating' => $newRating]);
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
     * @param RatingService $ratingService
     * @return Rating
     */
    public function setRatingService(RatingService $ratingService)
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
     * [Setter]
     *
     * @param ChapterService $chapterService
     * @return Rating
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
     * @return Rating
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