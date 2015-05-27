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
    public $type;

    /**
     * UID - corresponds to a social network id (Facebook, Twitter, Google, etc...)
     * @var string
     *
     * @Column(name="uid", type="string", length=50)
     */
    public $uid;

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

//     /**
//      * @Column(type="string", length=255)
//      * @var string
//      */
//     protected $email;

//     /**
//      * @Column(type="string", length=32)
//      * @var string
//      */
//     protected $password;

//     /**
//      * @return string
//      */
//     public function getEmail()
//     {
//         return $this->email;
//     }

//     /**
//      * @param string $email
//      */
//     public function setEmail($email)
//     {
//         $this->email = $email;
//     }

//     /**
//      * @return string
//      */
//     public function getPassword()
//     {
//         return $this->password;
//     }

//     /**
//      * @param string $password
//      */
//     public function setPassword($password)
//     {
//         $this->password = md5($password);
//     }
}