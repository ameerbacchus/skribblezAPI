<?php

namespace App\Entity;

use App\Entity\Base;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="chapters")
 */
class Chapter extends Base
{
    /**
     * Chapter sequence
     * @var integer
     *
     * @Column(name="sequence", type="integer")
     */
    public $sequence;

    /**
     * Chapter body
     * @var string
     *
     * @Column(name="body", type="string")
     */
    public $body;

    /**
     * Chapter title
     * @var string
     *
     * @Column(name="title", type="string", nullable=true)
     */
    public $title;

    /**
     * @todo
     *
     * Parent chapter/starter
     * @var Chapter
     */
    public $parent;

    /**
     * @todo
     *
     * Previous chapter
     * @var Chapter
     */
    public $prev;

    /**
     * @todo
     *
     * Author
     * @var User
     */
    public $author;

    /**
     * [Setter]
     *
     * @param integer $sequence
     * @return Chapter
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * [Setter]
     *
     * @param User $author
     * @return \App\Entity\Chapter
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * [Setter]
     *
     * @param string $body
     * @return Chapter
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
     * @param string $title
     * @return Chapter
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * [Setter]
     *
     * @param Chapter $parent
     * @return Chapter
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return Chapter
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * [Setter]
     *
     * @param Chapter $prev
     * @return Chapter
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return Chapter
     */
    public function getPrev()
    {
        return $this->prev;
    }
}