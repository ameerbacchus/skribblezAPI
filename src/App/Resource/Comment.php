<?php
namespace App\Resource;

use App\Resource;
use App\Service\Comment as CommentService;
use App\Service\Chapter as ChapterService;
use App\Service\User as UserService;

class Comment extends Resource
{

    /**
     *
     * @var \App\Service\Comment
     */
    private $commentService;

    /**
     * Init
     */
    public function init()
    {
        $this->setCommentService(new CommentService($this->getEntityManager()));
        $this->setChapterService(new ChapterService($this->getEntityManager()));
        $this->setUserService(new UserService($this->getEntityManager()));
    }

    /**
     * Get comments for a chapter
     *
     * @param string $chapterGuid
     */
    public function getComments($chapterGuid)
    {
        $comments = $this->getCommentService()->getComments($chapterGuid);
        self::response(self::STATUS_OK, [
            'comments' => $comments
        ]);
    }

    /**
     * Post a new comment
     *
     * @todo -- auth check
     *
     * @param string $chapterGuid
     */
    public function postComment($chapterGuid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();
        $json = $request->getBody();
        $params = json_decode($json);

        $body = $params->body;
        $userId = $params->user;
        $user = $this->getUserService()->getUser($userId);
        $chapter = $this->getChapterService()->getChapter($chapterGuid);

        $newComment = $this->getCommentService()->createComment($chapter, $user, $body);

        self::response(self::STATUS_CREATED, [
            'comment' => $newComment
        ]);
    }

    /**
     * Updates a comment
     *
     * @todo -- auth check
     *
     * @param string $guid
     */
    public function patchComment($guid)
    {
        $slim = $this->getSlim();
        $request = $slim->request();
        $json = $request->getBody();
        $params = json_decode($json);

        $body = $params->body;
        $userId = $params->user;

        $comment = $this->getCommentService()->getComment($guid);

        if ($userId !== $comment->getUser()->getGuid()) {
            self::response(self::STATUS_METHOD_NOT_ALLOWED, [
                'error' => 'User cannot update a comment they do not own. '
            ]);
            return;
        }

        $comment = $this->getCommentService()->updateComment($comment, $body);

        self::response(self::STATUS_OK, [
            'comment' => $comment
        ]);
    }

    /**
     * Deletes a comment
     *
     * @todo -- auth check
     *
     * @param string $guid
     */
    public function deleteComment($guid)
    {
        $comment = $this->getCommentService()->getComment($guid);
        if ($comment) {
            $this->getCommentService()->delete($comment);
        }

        self::response(self::STATUS_NO_CONTENT);
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
     * @param CommentService $commentService
     * @return Comment
     */
    public function setCommentService(CommentService $commentService)
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
     * @param ChapterService $chapterService
     * @return Comment
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
     * @return Comment
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