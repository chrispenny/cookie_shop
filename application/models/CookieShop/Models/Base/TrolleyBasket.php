<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\Basket as ChildBasket;
use CookieShop\Models\BasketQuery as ChildBasketQuery;
use CookieShop\Models\Trolley as ChildTrolley;
use CookieShop\Models\TrolleyBasket as ChildTrolleyBasket;
use CookieShop\Models\TrolleyBasketCookie as ChildTrolleyBasketCookie;
use CookieShop\Models\TrolleyBasketCookieQuery as ChildTrolleyBasketCookieQuery;
use CookieShop\Models\TrolleyBasketQuery as ChildTrolleyBasketQuery;
use CookieShop\Models\TrolleyQuery as ChildTrolleyQuery;
use CookieShop\Models\Map\TrolleyBasketCookieTableMap;
use CookieShop\Models\Map\TrolleyBasketTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'trolley_basket' table.
 *
 *
 *
 * @package    propel.generator.CookieShop.Models.Base
 */
abstract class TrolleyBasket implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\CookieShop\\Models\\Map\\TrolleyBasketTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the trolley_id field.
     *
     * @var        int
     */
    protected $trolley_id;

    /**
     * The value for the basket_id field.
     *
     * @var        int
     */
    protected $basket_id;

    /**
     * @var        ChildTrolley
     */
    protected $aTrolley;

    /**
     * @var        ChildBasket
     */
    protected $aBasket;

    /**
     * @var        ObjectCollection|ChildTrolleyBasketCookie[] Collection to store aggregation of ChildTrolleyBasketCookie objects.
     */
    protected $collTrolleyBasketCookies;
    protected $collTrolleyBasketCookiesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrolleyBasketCookie[]
     */
    protected $trolleyBasketCookiesScheduledForDeletion = null;

    /**
     * Initializes internal state of CookieShop\Models\Base\TrolleyBasket object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>TrolleyBasket</code> instance.  If
     * <code>obj</code> is an instance of <code>TrolleyBasket</code>, delegates to
     * <code>equals(TrolleyBasket)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|TrolleyBasket The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [trolley_id] column value.
     *
     * @return int
     */
    public function getTrolleyId()
    {
        return $this->trolley_id;
    }

    /**
     * Get the [basket_id] column value.
     *
     * @return int
     */
    public function getBasketId()
    {
        return $this->basket_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TrolleyBasketTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [trolley_id] column.
     *
     * @param int $v new value
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     */
    public function setTrolleyId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->trolley_id !== $v) {
            $this->trolley_id = $v;
            $this->modifiedColumns[TrolleyBasketTableMap::COL_TROLLEY_ID] = true;
        }

        if ($this->aTrolley !== null && $this->aTrolley->getId() !== $v) {
            $this->aTrolley = null;
        }

        return $this;
    } // setTrolleyId()

    /**
     * Set the value of [basket_id] column.
     *
     * @param int $v new value
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     */
    public function setBasketId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->basket_id !== $v) {
            $this->basket_id = $v;
            $this->modifiedColumns[TrolleyBasketTableMap::COL_BASKET_ID] = true;
        }

        if ($this->aBasket !== null && $this->aBasket->getId() !== $v) {
            $this->aBasket = null;
        }

        return $this;
    } // setBasketId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TrolleyBasketTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TrolleyBasketTableMap::translateFieldName('TrolleyId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trolley_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TrolleyBasketTableMap::translateFieldName('BasketId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->basket_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = TrolleyBasketTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\CookieShop\\Models\\TrolleyBasket'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aTrolley !== null && $this->trolley_id !== $this->aTrolley->getId()) {
            $this->aTrolley = null;
        }
        if ($this->aBasket !== null && $this->basket_id !== $this->aBasket->getId()) {
            $this->aBasket = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTrolleyBasketQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTrolley = null;
            $this->aBasket = null;
            $this->collTrolleyBasketCookies = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TrolleyBasket::setDeleted()
     * @see TrolleyBasket::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTrolleyBasketQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TrolleyBasketTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTrolley !== null) {
                if ($this->aTrolley->isModified() || $this->aTrolley->isNew()) {
                    $affectedRows += $this->aTrolley->save($con);
                }
                $this->setTrolley($this->aTrolley);
            }

            if ($this->aBasket !== null) {
                if ($this->aBasket->isModified() || $this->aBasket->isNew()) {
                    $affectedRows += $this->aBasket->save($con);
                }
                $this->setBasket($this->aBasket);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->trolleyBasketCookiesScheduledForDeletion !== null) {
                if (!$this->trolleyBasketCookiesScheduledForDeletion->isEmpty()) {
                    \CookieShop\Models\TrolleyBasketCookieQuery::create()
                        ->filterByPrimaryKeys($this->trolleyBasketCookiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->trolleyBasketCookiesScheduledForDeletion = null;
                }
            }

            if ($this->collTrolleyBasketCookies !== null) {
                foreach ($this->collTrolleyBasketCookies as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TrolleyBasketTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TrolleyBasketTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TrolleyBasketTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TrolleyBasketTableMap::COL_TROLLEY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'trolley_id';
        }
        if ($this->isColumnModified(TrolleyBasketTableMap::COL_BASKET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'basket_id';
        }

        $sql = sprintf(
            'INSERT INTO trolley_basket (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'trolley_id':
                        $stmt->bindValue($identifier, $this->trolley_id, PDO::PARAM_INT);
                        break;
                    case 'basket_id':
                        $stmt->bindValue($identifier, $this->basket_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrolleyBasketTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTrolleyId();
                break;
            case 2:
                return $this->getBasketId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['TrolleyBasket'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TrolleyBasket'][$this->hashCode()] = true;
        $keys = TrolleyBasketTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTrolleyId(),
            $keys[2] => $this->getBasketId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTrolley) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trolley';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trolley';
                        break;
                    default:
                        $key = 'Trolley';
                }

                $result[$key] = $this->aTrolley->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBasket) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'basket';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'basket';
                        break;
                    default:
                        $key = 'Basket';
                }

                $result[$key] = $this->aBasket->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTrolleyBasketCookies) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trolleyBasketCookies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trolley_basket_cookies';
                        break;
                    default:
                        $key = 'TrolleyBasketCookies';
                }

                $result[$key] = $this->collTrolleyBasketCookies->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\CookieShop\Models\TrolleyBasket
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrolleyBasketTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\CookieShop\Models\TrolleyBasket
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTrolleyId($value);
                break;
            case 2:
                $this->setBasketId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TrolleyBasketTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTrolleyId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setBasketId($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\CookieShop\Models\TrolleyBasket The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TrolleyBasketTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TrolleyBasketTableMap::COL_ID)) {
            $criteria->add(TrolleyBasketTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TrolleyBasketTableMap::COL_TROLLEY_ID)) {
            $criteria->add(TrolleyBasketTableMap::COL_TROLLEY_ID, $this->trolley_id);
        }
        if ($this->isColumnModified(TrolleyBasketTableMap::COL_BASKET_ID)) {
            $criteria->add(TrolleyBasketTableMap::COL_BASKET_ID, $this->basket_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTrolleyBasketQuery::create();
        $criteria->add(TrolleyBasketTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \CookieShop\Models\TrolleyBasket (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTrolleyId($this->getTrolleyId());
        $copyObj->setBasketId($this->getBasketId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTrolleyBasketCookies() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrolleyBasketCookie($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \CookieShop\Models\TrolleyBasket Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildTrolley object.
     *
     * @param  ChildTrolley $v
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTrolley(ChildTrolley $v = null)
    {
        if ($v === null) {
            $this->setTrolleyId(NULL);
        } else {
            $this->setTrolleyId($v->getId());
        }

        $this->aTrolley = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTrolley object, it will not be re-added.
        if ($v !== null) {
            $v->addTrolleyBasket($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTrolley object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTrolley The associated ChildTrolley object.
     * @throws PropelException
     */
    public function getTrolley(ConnectionInterface $con = null)
    {
        if ($this->aTrolley === null && ($this->trolley_id !== null)) {
            $this->aTrolley = ChildTrolleyQuery::create()->findPk($this->trolley_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTrolley->addTrolleyBaskets($this);
             */
        }

        return $this->aTrolley;
    }

    /**
     * Declares an association between this object and a ChildBasket object.
     *
     * @param  ChildBasket $v
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBasket(ChildBasket $v = null)
    {
        if ($v === null) {
            $this->setBasketId(NULL);
        } else {
            $this->setBasketId($v->getId());
        }

        $this->aBasket = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBasket object, it will not be re-added.
        if ($v !== null) {
            $v->addTrolleyBasket($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBasket object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBasket The associated ChildBasket object.
     * @throws PropelException
     */
    public function getBasket(ConnectionInterface $con = null)
    {
        if ($this->aBasket === null && ($this->basket_id !== null)) {
            $this->aBasket = ChildBasketQuery::create()->findPk($this->basket_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBasket->addTrolleyBaskets($this);
             */
        }

        return $this->aBasket;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('TrolleyBasketCookie' == $relationName) {
            return $this->initTrolleyBasketCookies();
        }
    }

    /**
     * Clears out the collTrolleyBasketCookies collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTrolleyBasketCookies()
     */
    public function clearTrolleyBasketCookies()
    {
        $this->collTrolleyBasketCookies = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTrolleyBasketCookies collection loaded partially.
     */
    public function resetPartialTrolleyBasketCookies($v = true)
    {
        $this->collTrolleyBasketCookiesPartial = $v;
    }

    /**
     * Initializes the collTrolleyBasketCookies collection.
     *
     * By default this just sets the collTrolleyBasketCookies collection to an empty array (like clearcollTrolleyBasketCookies());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTrolleyBasketCookies($overrideExisting = true)
    {
        if (null !== $this->collTrolleyBasketCookies && !$overrideExisting) {
            return;
        }

        $collectionClassName = TrolleyBasketCookieTableMap::getTableMap()->getCollectionClassName();

        $this->collTrolleyBasketCookies = new $collectionClassName;
        $this->collTrolleyBasketCookies->setModel('\CookieShop\Models\TrolleyBasketCookie');
    }

    /**
     * Gets an array of ChildTrolleyBasketCookie objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrolleyBasket is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrolleyBasketCookie[] List of ChildTrolleyBasketCookie objects
     * @throws PropelException
     */
    public function getTrolleyBasketCookies(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTrolleyBasketCookiesPartial && !$this->isNew();
        if (null === $this->collTrolleyBasketCookies || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTrolleyBasketCookies) {
                // return empty collection
                $this->initTrolleyBasketCookies();
            } else {
                $collTrolleyBasketCookies = ChildTrolleyBasketCookieQuery::create(null, $criteria)
                    ->filterByTrolleyBasket($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTrolleyBasketCookiesPartial && count($collTrolleyBasketCookies)) {
                        $this->initTrolleyBasketCookies(false);

                        foreach ($collTrolleyBasketCookies as $obj) {
                            if (false == $this->collTrolleyBasketCookies->contains($obj)) {
                                $this->collTrolleyBasketCookies->append($obj);
                            }
                        }

                        $this->collTrolleyBasketCookiesPartial = true;
                    }

                    return $collTrolleyBasketCookies;
                }

                if ($partial && $this->collTrolleyBasketCookies) {
                    foreach ($this->collTrolleyBasketCookies as $obj) {
                        if ($obj->isNew()) {
                            $collTrolleyBasketCookies[] = $obj;
                        }
                    }
                }

                $this->collTrolleyBasketCookies = $collTrolleyBasketCookies;
                $this->collTrolleyBasketCookiesPartial = false;
            }
        }

        return $this->collTrolleyBasketCookies;
    }

    /**
     * Sets a collection of ChildTrolleyBasketCookie objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $trolleyBasketCookies A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTrolleyBasket The current object (for fluent API support)
     */
    public function setTrolleyBasketCookies(Collection $trolleyBasketCookies, ConnectionInterface $con = null)
    {
        /** @var ChildTrolleyBasketCookie[] $trolleyBasketCookiesToDelete */
        $trolleyBasketCookiesToDelete = $this->getTrolleyBasketCookies(new Criteria(), $con)->diff($trolleyBasketCookies);


        $this->trolleyBasketCookiesScheduledForDeletion = $trolleyBasketCookiesToDelete;

        foreach ($trolleyBasketCookiesToDelete as $trolleyBasketCookieRemoved) {
            $trolleyBasketCookieRemoved->setTrolleyBasket(null);
        }

        $this->collTrolleyBasketCookies = null;
        foreach ($trolleyBasketCookies as $trolleyBasketCookie) {
            $this->addTrolleyBasketCookie($trolleyBasketCookie);
        }

        $this->collTrolleyBasketCookies = $trolleyBasketCookies;
        $this->collTrolleyBasketCookiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TrolleyBasketCookie objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TrolleyBasketCookie objects.
     * @throws PropelException
     */
    public function countTrolleyBasketCookies(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTrolleyBasketCookiesPartial && !$this->isNew();
        if (null === $this->collTrolleyBasketCookies || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTrolleyBasketCookies) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTrolleyBasketCookies());
            }

            $query = ChildTrolleyBasketCookieQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrolleyBasket($this)
                ->count($con);
        }

        return count($this->collTrolleyBasketCookies);
    }

    /**
     * Method called to associate a ChildTrolleyBasketCookie object to this object
     * through the ChildTrolleyBasketCookie foreign key attribute.
     *
     * @param  ChildTrolleyBasketCookie $l ChildTrolleyBasketCookie
     * @return $this|\CookieShop\Models\TrolleyBasket The current object (for fluent API support)
     */
    public function addTrolleyBasketCookie(ChildTrolleyBasketCookie $l)
    {
        if ($this->collTrolleyBasketCookies === null) {
            $this->initTrolleyBasketCookies();
            $this->collTrolleyBasketCookiesPartial = true;
        }

        if (!$this->collTrolleyBasketCookies->contains($l)) {
            $this->doAddTrolleyBasketCookie($l);

            if ($this->trolleyBasketCookiesScheduledForDeletion and $this->trolleyBasketCookiesScheduledForDeletion->contains($l)) {
                $this->trolleyBasketCookiesScheduledForDeletion->remove($this->trolleyBasketCookiesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTrolleyBasketCookie $trolleyBasketCookie The ChildTrolleyBasketCookie object to add.
     */
    protected function doAddTrolleyBasketCookie(ChildTrolleyBasketCookie $trolleyBasketCookie)
    {
        $this->collTrolleyBasketCookies[]= $trolleyBasketCookie;
        $trolleyBasketCookie->setTrolleyBasket($this);
    }

    /**
     * @param  ChildTrolleyBasketCookie $trolleyBasketCookie The ChildTrolleyBasketCookie object to remove.
     * @return $this|ChildTrolleyBasket The current object (for fluent API support)
     */
    public function removeTrolleyBasketCookie(ChildTrolleyBasketCookie $trolleyBasketCookie)
    {
        if ($this->getTrolleyBasketCookies()->contains($trolleyBasketCookie)) {
            $pos = $this->collTrolleyBasketCookies->search($trolleyBasketCookie);
            $this->collTrolleyBasketCookies->remove($pos);
            if (null === $this->trolleyBasketCookiesScheduledForDeletion) {
                $this->trolleyBasketCookiesScheduledForDeletion = clone $this->collTrolleyBasketCookies;
                $this->trolleyBasketCookiesScheduledForDeletion->clear();
            }
            $this->trolleyBasketCookiesScheduledForDeletion[]= clone $trolleyBasketCookie;
            $trolleyBasketCookie->setTrolleyBasket(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TrolleyBasket is new, it will return
     * an empty collection; or if this TrolleyBasket has previously
     * been saved, it will retrieve related TrolleyBasketCookies from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TrolleyBasket.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrolleyBasketCookie[] List of ChildTrolleyBasketCookie objects
     */
    public function getTrolleyBasketCookiesJoinCookie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTrolleyBasketCookieQuery::create(null, $criteria);
        $query->joinWith('Cookie', $joinBehavior);

        return $this->getTrolleyBasketCookies($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTrolley) {
            $this->aTrolley->removeTrolleyBasket($this);
        }
        if (null !== $this->aBasket) {
            $this->aBasket->removeTrolleyBasket($this);
        }
        $this->id = null;
        $this->trolley_id = null;
        $this->basket_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTrolleyBasketCookies) {
                foreach ($this->collTrolleyBasketCookies as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTrolleyBasketCookies = null;
        $this->aTrolley = null;
        $this->aBasket = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TrolleyBasketTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}