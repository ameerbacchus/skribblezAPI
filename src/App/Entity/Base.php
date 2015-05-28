<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks()
 */
abstract class Base
{
    /**
     * Primary key
     * @var integer
     *
     * @Column(name="_id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * GUID
     * @var string
     *
     * @Column(name="_guid", type="string", length=45, unique=true)
     */
    public $guid;

    /**
     * Create date (UTC time)
     * @var integer
     *
     * @Column(name="_created", type="integer")
     */
    public $created;

    /**
     * Update date (UTC time)
     * @var integer
     *
     * @Column(name="_updated", type="integer")
     */
    public $updated;

    /**
     * Deleted flag
     * @var bool
     *
     * @Column(name="_deleted", type="boolean")
     */
    protected $deleted = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $now = time();
        $this->setGuid(com_create_guid());
        $this->setCreated($now);
        $this->setUpdated($now);
    }

    /**
     * @PreUpdate
     */
    public function setUpdatedValue()
    {
        $now = time();
        $this->setUpdated($now);
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * [Setter]
     *
     * @param string $guid
     * @return Base
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * [Setter]
     *
     * @param integer $created
     * @return Base
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * [Setter]
     *
     * @param integer $updated
     * @return Base
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return integer
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * [Setter]
     *
     * @param boolean $deleted
     * @return Base
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}