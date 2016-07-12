<?php

namespace CookieShop\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use CookieShop\Models\CiSession as ChildCiSession;
use CookieShop\Models\CiSessionQuery as ChildCiSessionQuery;
use CookieShop\Models\Trolley as ChildTrolley;
use CookieShop\Models\TrolleyBasket as ChildTrolleyBasket;
use CookieShop\Models\TrolleyBasketQuery as ChildTrolleyBasketQuery;
use CookieShop\Models\TrolleyQuery as ChildTrolleyQuery;
use CookieShop\Models\Map\TrolleyBasketTableMap;
use CookieShop\Models\Map\TrolleyTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'trolley' table.
 *
 *
 *
 * @package    propel.generator.CookieShop.Models.Base
 */
abstract class Trolley implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\CookieShop\\Models\\Map\\TrolleyTableMap';


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
     * The value for the ci_session_id field.
     *
     * @var        string
     */
    protected $ci_session_id;

    /**
     * The value for the customer_id field.
     *
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the last_modified field.
     *
     * @var        DateTime
     */
    protected $last_modified;

    /**
     * @var        ChildCiSession
     */
    protected $aCiSession;

    /**
     * @var        ObjectCollection|ChildTrolleyBasket[] Collection to store aggregation of ChildTrolleyBasket objects.
     */
    protected $collTrolleyBaskets;
    protected $collTrolleyBasketsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrolleyBasket[]
     */
    protected $trolleyBasketsScheduledForDeletion = null;

    /**
     * Initializes internal state of CookieShop\Models\Base\Trolley object.
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
     * Compares this with another <code>Trolley</code> instance.  If
     * <code>obj</code> is an instance of <code>Trolley</code>, delegates to
     * <code>equals(Trolley)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Trolley The current object, for fluid interface
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
     * Get the [ci_session_id] column value.
     *
     * @return string
     */
    public function getCiSessionId()
    {
        return $this->ci_session_id;
    }

    /**
     * Get the [customer_id] column value.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Get the [optionally formatted] temporal [last_modified] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastModified($format = NULL)
    {
        if ($format === null) {
            return $this->last_modified;
        } else {
            return $this->last_modified instanceof \DateTimeInterface ? $this->last_modified->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TrolleyTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [ci_session_id] column.
     *
     * @param string $v new value
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     */
    public function setCiSessionId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ci_session_id !== $v) {
            $this->ci_session_id = $v;
            $this->modifiedColumns[TrolleyTableMap::COL_CI_SESSION_ID] = true;
        }

        if ($this->aCiSession !== null && $this->aCiSession->getSessionId() !== $v) {
            $this->aCiSession = null;
        }

        return $this;
    } // setCiSessionId()

    /**
     * Set the value of [customer_id] column.
     *
     * @param int $v new value
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[TrolleyTableMap::COL_CUSTOMER_ID] = true;
        }

        return $this;
    } // setCustomerId()

    /**
     * Sets the value of [last_modified] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     */
    public function setLastModified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_modified !== null || $dt !== null) {
            if ($this->last_modified === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_modified->format("Y-m-d H:i:s.u")) {
                $this->last_modified = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TrolleyTableMap::COL_LAST_MODIFIED] = true;
            }
        } // if either are not null

        return $this;
    } // setLastModified()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TrolleyTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TrolleyTableMap::translateFieldName('CiSessionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ci_session_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TrolleyTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TrolleyTableMap::translateFieldName('LastModified', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_modified = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = TrolleyTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\CookieShop\\Models\\Trolley'), 0, $e);
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
        if ($this->aCiSession !== null && $this->ci_session_id !== $this->aCiSession->getSessionId()) {
            $this->aCiSession = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(TrolleyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTrolleyQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCiSession = null;
            $this->collTrolleyBaskets = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Trolley::setDeleted()
     * @see Trolley::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTrolleyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyTableMap::DATABASE_NAME);
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
                TrolleyTableMap::addInstanceToPool($this);
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

            if ($this->aCiSession !== null) {
                if ($this->aCiSession->isModified() || $this->aCiSession->isNew()) {
                    $affectedRows += $this->aCiSession->save($con);
                }
                $this->setCiSession($this->aCiSession);
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

            if ($this->trolleyBasketsScheduledForDeletion !== null) {
                if (!$this->trolleyBasketsScheduledForDeletion->isEmpty()) {
                    \CookieShop\Models\TrolleyBasketQuery::create()
                        ->filterByPrimaryKeys($this->trolleyBasketsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->trolleyBasketsScheduledForDeletion = null;
                }
            }

            if ($this->collTrolleyBaskets !== null) {
                foreach ($this->collTrolleyBaskets as $referrerFK) {
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

        $this->modifiedColumns[TrolleyTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TrolleyTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TrolleyTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_CI_SESSION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ci_session_id';
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'customer_id';
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_LAST_MODIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'last_modified';
        }

        $sql = sprintf(
            'INSERT INTO trolley (%s) VALUES (%s)',
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
                    case 'ci_session_id':
                        $stmt->bindValue($identifier, $this->ci_session_id, PDO::PARAM_STR);
                        break;
                    case 'customer_id':
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case 'last_modified':
                        $stmt->bindValue($identifier, $this->last_modified ? $this->last_modified->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = TrolleyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCiSessionId();
                break;
            case 2:
                return $this->getCustomerId();
                break;
            case 3:
                return $this->getLastModified();
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

        if (isset($alreadyDumpedObjects['Trolley'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Trolley'][$this->hashCode()] = true;
        $keys = TrolleyTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCiSessionId(),
            $keys[2] => $this->getCustomerId(),
            $keys[3] => $this->getLastModified(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCiSession) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ciSession';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ci_sessions';
                        break;
                    default:
                        $key = 'CiSession';
                }

                $result[$key] = $this->aCiSession->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTrolleyBaskets) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trolleyBaskets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trolley_baskets';
                        break;
                    default:
                        $key = 'TrolleyBaskets';
                }

                $result[$key] = $this->collTrolleyBaskets->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\CookieShop\Models\Trolley
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrolleyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\CookieShop\Models\Trolley
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCiSessionId($value);
                break;
            case 2:
                $this->setCustomerId($value);
                break;
            case 3:
                $this->setLastModified($value);
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
        $keys = TrolleyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCiSessionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCustomerId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLastModified($arr[$keys[3]]);
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
     * @return $this|\CookieShop\Models\Trolley The current object, for fluid interface
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
        $criteria = new Criteria(TrolleyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TrolleyTableMap::COL_ID)) {
            $criteria->add(TrolleyTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_CI_SESSION_ID)) {
            $criteria->add(TrolleyTableMap::COL_CI_SESSION_ID, $this->ci_session_id);
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_CUSTOMER_ID)) {
            $criteria->add(TrolleyTableMap::COL_CUSTOMER_ID, $this->customer_id);
        }
        if ($this->isColumnModified(TrolleyTableMap::COL_LAST_MODIFIED)) {
            $criteria->add(TrolleyTableMap::COL_LAST_MODIFIED, $this->last_modified);
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
        $criteria = ChildTrolleyQuery::create();
        $criteria->add(TrolleyTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \CookieShop\Models\Trolley (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCiSessionId($this->getCiSessionId());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setLastModified($this->getLastModified());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTrolleyBaskets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrolleyBasket($relObj->copy($deepCopy));
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
     * @return \CookieShop\Models\Trolley Clone of current object.
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
     * Declares an association between this object and a ChildCiSession object.
     *
     * @param  ChildCiSession $v
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCiSession(ChildCiSession $v = null)
    {
        if ($v === null) {
            $this->setCiSessionId(NULL);
        } else {
            $this->setCiSessionId($v->getSessionId());
        }

        $this->aCiSession = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCiSession object, it will not be re-added.
        if ($v !== null) {
            $v->addTrolley($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCiSession object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCiSession The associated ChildCiSession object.
     * @throws PropelException
     */
    public function getCiSession(ConnectionInterface $con = null)
    {
        if ($this->aCiSession === null && (($this->ci_session_id !== "" && $this->ci_session_id !== null))) {
            $this->aCiSession = ChildCiSessionQuery::create()->findPk($this->ci_session_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCiSession->addTrolleys($this);
             */
        }

        return $this->aCiSession;
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
        if ('TrolleyBasket' == $relationName) {
            return $this->initTrolleyBaskets();
        }
    }

    /**
     * Clears out the collTrolleyBaskets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTrolleyBaskets()
     */
    public function clearTrolleyBaskets()
    {
        $this->collTrolleyBaskets = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTrolleyBaskets collection loaded partially.
     */
    public function resetPartialTrolleyBaskets($v = true)
    {
        $this->collTrolleyBasketsPartial = $v;
    }

    /**
     * Initializes the collTrolleyBaskets collection.
     *
     * By default this just sets the collTrolleyBaskets collection to an empty array (like clearcollTrolleyBaskets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTrolleyBaskets($overrideExisting = true)
    {
        if (null !== $this->collTrolleyBaskets && !$overrideExisting) {
            return;
        }

        $collectionClassName = TrolleyBasketTableMap::getTableMap()->getCollectionClassName();

        $this->collTrolleyBaskets = new $collectionClassName;
        $this->collTrolleyBaskets->setModel('\CookieShop\Models\TrolleyBasket');
    }

    /**
     * Gets an array of ChildTrolleyBasket objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrolley is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrolleyBasket[] List of ChildTrolleyBasket objects
     * @throws PropelException
     */
    public function getTrolleyBaskets(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTrolleyBasketsPartial && !$this->isNew();
        if (null === $this->collTrolleyBaskets || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTrolleyBaskets) {
                // return empty collection
                $this->initTrolleyBaskets();
            } else {
                $collTrolleyBaskets = ChildTrolleyBasketQuery::create(null, $criteria)
                    ->filterByTrolley($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTrolleyBasketsPartial && count($collTrolleyBaskets)) {
                        $this->initTrolleyBaskets(false);

                        foreach ($collTrolleyBaskets as $obj) {
                            if (false == $this->collTrolleyBaskets->contains($obj)) {
                                $this->collTrolleyBaskets->append($obj);
                            }
                        }

                        $this->collTrolleyBasketsPartial = true;
                    }

                    return $collTrolleyBaskets;
                }

                if ($partial && $this->collTrolleyBaskets) {
                    foreach ($this->collTrolleyBaskets as $obj) {
                        if ($obj->isNew()) {
                            $collTrolleyBaskets[] = $obj;
                        }
                    }
                }

                $this->collTrolleyBaskets = $collTrolleyBaskets;
                $this->collTrolleyBasketsPartial = false;
            }
        }

        return $this->collTrolleyBaskets;
    }

    /**
     * Sets a collection of ChildTrolleyBasket objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $trolleyBaskets A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTrolley The current object (for fluent API support)
     */
    public function setTrolleyBaskets(Collection $trolleyBaskets, ConnectionInterface $con = null)
    {
        /** @var ChildTrolleyBasket[] $trolleyBasketsToDelete */
        $trolleyBasketsToDelete = $this->getTrolleyBaskets(new Criteria(), $con)->diff($trolleyBaskets);


        $this->trolleyBasketsScheduledForDeletion = $trolleyBasketsToDelete;

        foreach ($trolleyBasketsToDelete as $trolleyBasketRemoved) {
            $trolleyBasketRemoved->setTrolley(null);
        }

        $this->collTrolleyBaskets = null;
        foreach ($trolleyBaskets as $trolleyBasket) {
            $this->addTrolleyBasket($trolleyBasket);
        }

        $this->collTrolleyBaskets = $trolleyBaskets;
        $this->collTrolleyBasketsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TrolleyBasket objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TrolleyBasket objects.
     * @throws PropelException
     */
    public function countTrolleyBaskets(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTrolleyBasketsPartial && !$this->isNew();
        if (null === $this->collTrolleyBaskets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTrolleyBaskets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTrolleyBaskets());
            }

            $query = ChildTrolleyBasketQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrolley($this)
                ->count($con);
        }

        return count($this->collTrolleyBaskets);
    }

    /**
     * Method called to associate a ChildTrolleyBasket object to this object
     * through the ChildTrolleyBasket foreign key attribute.
     *
     * @param  ChildTrolleyBasket $l ChildTrolleyBasket
     * @return $this|\CookieShop\Models\Trolley The current object (for fluent API support)
     */
    public function addTrolleyBasket(ChildTrolleyBasket $l)
    {
        if ($this->collTrolleyBaskets === null) {
            $this->initTrolleyBaskets();
            $this->collTrolleyBasketsPartial = true;
        }

        if (!$this->collTrolleyBaskets->contains($l)) {
            $this->doAddTrolleyBasket($l);

            if ($this->trolleyBasketsScheduledForDeletion and $this->trolleyBasketsScheduledForDeletion->contains($l)) {
                $this->trolleyBasketsScheduledForDeletion->remove($this->trolleyBasketsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTrolleyBasket $trolleyBasket The ChildTrolleyBasket object to add.
     */
    protected function doAddTrolleyBasket(ChildTrolleyBasket $trolleyBasket)
    {
        $this->collTrolleyBaskets[]= $trolleyBasket;
        $trolleyBasket->setTrolley($this);
    }

    /**
     * @param  ChildTrolleyBasket $trolleyBasket The ChildTrolleyBasket object to remove.
     * @return $this|ChildTrolley The current object (for fluent API support)
     */
    public function removeTrolleyBasket(ChildTrolleyBasket $trolleyBasket)
    {
        if ($this->getTrolleyBaskets()->contains($trolleyBasket)) {
            $pos = $this->collTrolleyBaskets->search($trolleyBasket);
            $this->collTrolleyBaskets->remove($pos);
            if (null === $this->trolleyBasketsScheduledForDeletion) {
                $this->trolleyBasketsScheduledForDeletion = clone $this->collTrolleyBaskets;
                $this->trolleyBasketsScheduledForDeletion->clear();
            }
            $this->trolleyBasketsScheduledForDeletion[]= clone $trolleyBasket;
            $trolleyBasket->setTrolley(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Trolley is new, it will return
     * an empty collection; or if this Trolley has previously
     * been saved, it will retrieve related TrolleyBaskets from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Trolley.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrolleyBasket[] List of ChildTrolleyBasket objects
     */
    public function getTrolleyBasketsJoinBasket(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTrolleyBasketQuery::create(null, $criteria);
        $query->joinWith('Basket', $joinBehavior);

        return $this->getTrolleyBaskets($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCiSession) {
            $this->aCiSession->removeTrolley($this);
        }
        $this->id = null;
        $this->ci_session_id = null;
        $this->customer_id = null;
        $this->last_modified = null;
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
            if ($this->collTrolleyBaskets) {
                foreach ($this->collTrolleyBaskets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTrolleyBaskets = null;
        $this->aCiSession = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TrolleyTableMap::DEFAULT_STRING_FORMAT);
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
