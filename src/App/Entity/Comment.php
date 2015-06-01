<?php
namespace App\Entity;

use App\Entity\Base;
use App\Entity\User;
use App\Entity\Chapter;
use Doctrine\ORM\Mapping;

/**
 * @Entity(repositoryClass="App\Repository\Comment")
 * @Table(name="comments")
 */
class Comment extends Base
{

    /**
     * Comment body
     *
     * @Column(name="body", type="string")
     *
     * @var string
     */
    public $body;

    /**
     * Chapter
     *
     * @ManyToOne(targetEntity="App\Entity\Chapter")
     * @JoinColumn(name="chapter_id", referencedColumnName="_id")
     *
     * @var Chapter
     */
    protected $chapter;

    /**
     * User
     *
     * @ManyToOne(targetEntity="App\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="_id")
     *
     * @var User
     */
    public $user;

    /**
     * [Setter]
     *
     * @param string $body
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * [Setter]
     *
     * @param Chapter $chapter
     * @return Comment
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * [Setter]
     *
     * @param User $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}