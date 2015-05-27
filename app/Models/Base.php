<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Base model class
 * @author david.mi.shaw@gmail.com
 */
class Base extends Model {

    /**
     * Constant overrides
     */
//     const CREATED_AT = '_created';
//     const UPDATED_AT = '_updated';
//     const DELETED_AT = '_deleted';

    /**
     * @override
     * @var string
     */
    protected $primaryKey = '_id';

    //     protected $softDelete = true;

    /**
     * @override
     * @var boolean
     */
    public $timestamps = false;

    //     /**
    //      * Primary key
    //      * @var int
    //      */
    //     protected $_id;

    //     /**
    //      * GUID
    //      * @var string
    //      */
    //     protected $_guid;

    //     /**
    //      * Deleted flag
    //      * @var boolean
    //      */
    //     protected $_deleted = false;

    /**
     * Created at timestamp (UNIX timestamp)
     * @var int
     */
    //     protected $_created = 0;

    /**
     * Updated at timestamp (UNIX timestamp)
     * @var int
     */
    //     protected $_updated = 0;


    /**
     * Constructor override
     *
     * @param array $attributes
     * @see \Illuminate\Database\Eloquent\Model::__construct()
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * @override
     * @see \Illuminate\Database\Eloquent\Model::save($options)
     */
    public function save(array $options = array())
    {
        $now = time();

        if (!$this->exists) {
            $this->setAttribute('_guid', com_create_guid());
            $this->setAttribute('_created', $now);
        }

        $this->setAttribute('_updated', $now);

        parent::save($options);
    }

    /**
     * Returns all rows for a table
     *
     * @param array $columns
     *
     * @override
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = array('*'))
    {
        $instance = new static;
        return $instance->newQuery()->where('_deleted', '=', 0)->get($columns);
    }

    /**
     * Deletes an row
     *
     * @override
     * @see \Illuminate\Database\Eloquent\Model::delete()
     */
    public function delete()
    {
        if (is_null($this->primaryKey)) {
            throw new Exception("No primary key defined on model.");
        }

        if ($this->exists) {
            if ($this->fireModelEvent('deleting') === false) {
                return false;
            }

            // Here, we'll touch the owning models, verifying these timestamps get updated
            // for the models. This will allow any caching to get broken on the parents
            // by the timestamp. Then we will go ahead and delete the model instance.
            $this->touchOwners();

            //             $this->performDeleteOnModel();

            $this->setAttribute('_deleted', 1);
            $this->save();

            $this->exists = false;

            // Once the model has been deleted, we will fire off the deleted event so that
            // the developers may hook into post-delete operations. We will then return
            // a boolean true as the delete is presumably successful on the database.
            $this->fireModelEvent('deleted', false);

            return true;
        }
    }
}
