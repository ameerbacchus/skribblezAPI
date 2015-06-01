<?php
namespace App\Entity;

use App\Entity\Base;
use App\Entity\User;
use Doctrine\ORM\Mapping;

/**
 * @Entity(repositoryClass="App\Repository\ChapterPath")
 * @Table(name="chapter_path")
 */
class ChapterPath extends Base
{

    const PATH_DELIMITER = '|';

    /**
     * Path string: a set of comma-separated Chapter GUIDs
     *
     * @Column(name="path", type="string")
     *
     * @var string
     */
    public $path;

    /**
     * [Setter]
     *
     * @param string $path
     * @return ChapterPath
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * [Getter]
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Takes an array of GUIds and combines then into a string to set the path
     *
     * @param array $pathGuids
     * @return ChapterPath
     */
    public function setPathGuids($pathGuids)
    {
        $this->setPath(implode(self::PATH_DELIMITER, $pathGuids));
        return $this;
    }

    /**
     * Returns an array of all of the GUIDs in the path string
     *
     * @return array:
     */
    public function getPathGuids()
    {
        return explode(self::PATH_DELIMITER, $this->path);
    }
}