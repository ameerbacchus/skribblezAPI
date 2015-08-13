<?php
namespace App\Resource;

use App\Resource;
use App\Service\Rating as RatingService;
use App\Service\Chapter as ChapterService;
use App\Service\User as UserService;

class Rating extends Resource
{

    /**
     *
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
     * @todo -- auth check
     *
     * @param string $chapterGuid
     */
    public function postRating($chapterGuid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();
        $json = $request->getBody();
        $params = json_decode($json);

        $score = $params->score;
        $userId = $params->user;    // @todo -- need proper authentication
        $user = $this->getUserService()->getUser($userId);
        $chapter = $this->getChapterService()->getChapter($chapterGuid);

        $userRating = $this->getRatingService()->getUserRating($chapter, $user);
        if ($userRating) {
            self::response(self::STATUS_METHOD_NOT_ALLOWED, [
                'error' => 'User has already rated this.'
            ]);
            return;
        }

        $newRating = $this->getRatingService()->createRating($chapter, $user, $score);

        self::response(self::STATUS_CREATED, [
            'rating' => $newRating
        ]);
    }

    /**
     * Update a rating
     *
     * @todo -- auth check
     *
     * @param string $guid
     */
    public function patchRating($guid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();
        $json = $request->getBody();
        $params = json_decode($json);

        $score = $params->score;
        $userId = $params->user;    // @todo -- need proper authentication
        $rating = $this->getRatingService()->getRating($guid);

        if ($userId !== $rating->getUser()->getGuid()) {
            self::response(self::STATUS_METHOD_NOT_ALLOWED, [
                'error' => 'User cannot update a rating they do not own. '
            ]);
            return;
        }

        $rating = $this->getRatingService()->updateRating($rating, $score);

        self::response(self::STATUS_OK, [
            'rating' => $rating
        ]);
    }

    /**
     * Show options in header
     */
    public function options()
    {
        self::response(self::STATUS_OK, array(), array(
            'GET',
            'POST',
            'PUT',
            'DELETE',
            'OPTIONS'
        ));
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
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}