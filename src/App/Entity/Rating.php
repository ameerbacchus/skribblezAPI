<?php

namespace App\Entity;

use App\Entity\Base;
use App\Entity\User;
use App\Entity\Chapter;
use Doctrine\ORM\Mapping;

/**
 * @Entity(repositoryClass="App\Repository\Rating")
 * @Table(name="ratings")
 */
class Rating extends Base
{
    /**
     * Rating score
     * @var integer
     *
     * @Column(name="score", type="integer")
     */
    public $score;

    /**
     * Chapter
     * @var Chapter
     *
     * @ManyToOne(targetEntity="App\Entity\Chapter")
     * @JoinColumn(name="chapter_id", referencedColumnName="_id")
     */
    protected $chapter;

    /**
     * User
     * @var User
     *
     * @ManyToOne(targetEntity="App\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="_id")
     */
    protected $user;

    /**
     * [Setter]
     *
     * @param integer $score
     * @return Rating
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * [Setter]
     *
     * @param Chapter $chapter
     * @return Rating
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
     * @return Rating
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