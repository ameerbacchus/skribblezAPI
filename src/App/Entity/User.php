<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="users")
 */
class User extends Base
{

    /**
     * Type of user (enumeration): Facebook, Twitter, Google, etc...
     * @var integer
     *
     * @Column(name="type", type="integer")
     */
    protected $type;

    /**
     * UID - corresponds to a social network id (Facebook, Twitter, Google, etc...)
     * @var string
     *
     * @Column(name="uid", type="string", length=50)
     */
    protected $uid;

    /**
     * First Name
     * @var string
     *
     * @Column(name="first_name", type="string", length=100)
     */
    public $firstName;

    /**
     * First Name
     * @var string
     *
     * @Column(name="last_name", type="string", length=100)
     */
    public $lastName;

    /**
     * [Setter]
     *
     * @param integer $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * [Setter]
     *
     * @param string $uid
     * @return User
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * [Setter]
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * [Setter]
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}