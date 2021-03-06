<?php

namespace CookieShop\Models\Map;

use CookieShop\Models\CiSession;
use CookieShop\Models\CiSessionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'ci_sessions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CiSessionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'CookieShop.Models.Map.CiSessionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ci_sessions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CookieShop\\Models\\CiSession';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CookieShop.Models.CiSession';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the session_id field
     */
    const COL_SESSION_ID = 'ci_sessions.session_id';

    /**
     * the column name for the ip_address field
     */
    const COL_IP_ADDRESS = 'ci_sessions.ip_address';

    /**
     * the column name for the user_agent field
     */
    const COL_USER_AGENT = 'ci_sessions.user_agent';

    /**
     * the column name for the last_activity field
     */
    const COL_LAST_ACTIVITY = 'ci_sessions.last_activity';

    /**
     * the column name for the user_data field
     */
    const COL_USER_DATA = 'ci_sessions.user_data';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('SessionId', 'IpAddress', 'UserAgent', 'LastActivity', 'UserData', ),
        self::TYPE_CAMELNAME     => array('sessionId', 'ipAddress', 'userAgent', 'lastActivity', 'userData', ),
        self::TYPE_COLNAME       => array(CiSessionTableMap::COL_SESSION_ID, CiSessionTableMap::COL_IP_ADDRESS, CiSessionTableMap::COL_USER_AGENT, CiSessionTableMap::COL_LAST_ACTIVITY, CiSessionTableMap::COL_USER_DATA, ),
        self::TYPE_FIELDNAME     => array('session_id', 'ip_address', 'user_agent', 'last_activity', 'user_data', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('SessionId' => 0, 'IpAddress' => 1, 'UserAgent' => 2, 'LastActivity' => 3, 'UserData' => 4, ),
        self::TYPE_CAMELNAME     => array('sessionId' => 0, 'ipAddress' => 1, 'userAgent' => 2, 'lastActivity' => 3, 'userData' => 4, ),
        self::TYPE_COLNAME       => array(CiSessionTableMap::COL_SESSION_ID => 0, CiSessionTableMap::COL_IP_ADDRESS => 1, CiSessionTableMap::COL_USER_AGENT => 2, CiSessionTableMap::COL_LAST_ACTIVITY => 3, CiSessionTableMap::COL_USER_DATA => 4, ),
        self::TYPE_FIELDNAME     => array('session_id' => 0, 'ip_address' => 1, 'user_agent' => 2, 'last_activity' => 3, 'user_data' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('ci_sessions');
        $this->setPhpName('CiSession');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CookieShop\\Models\\CiSession');
        $this->setPackage('CookieShop.Models');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('session_id', 'SessionId', 'VARCHAR', true, 40, null);
        $this->addColumn('ip_address', 'IpAddress', 'VARCHAR', true, 45, null);
        $this->addColumn('user_agent', 'UserAgent', 'VARCHAR', true, 120, null);
        $this->addColumn('last_activity', 'LastActivity', 'INTEGER', true, null, null);
        $this->addColumn('user_data', 'UserData', 'LONGVARCHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Trolley', '\\CookieShop\\Models\\Trolley', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ci_session_id',
    1 => ':session_id',
  ),
), null, null, 'Trolleys', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('SessionId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CiSessionTableMap::CLASS_DEFAULT : CiSessionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (CiSession object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CiSessionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CiSessionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CiSessionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CiSessionTableMap::OM_CLASS;
            /** @var CiSession $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CiSessionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CiSessionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CiSessionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CiSession $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CiSessionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CiSessionTableMap::COL_SESSION_ID);
            $criteria->addSelectColumn(CiSessionTableMap::COL_IP_ADDRESS);
            $criteria->addSelectColumn(CiSessionTableMap::COL_USER_AGENT);
            $criteria->addSelectColumn(CiSessionTableMap::COL_LAST_ACTIVITY);
            $criteria->addSelectColumn(CiSessionTableMap::COL_USER_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.session_id');
            $criteria->addSelectColumn($alias . '.ip_address');
            $criteria->addSelectColumn($alias . '.user_agent');
            $criteria->addSelectColumn($alias . '.last_activity');
            $criteria->addSelectColumn($alias . '.user_data');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CiSessionTableMap::DATABASE_NAME)->getTable(CiSessionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CiSessionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CiSessionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CiSessionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CiSession or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CiSession object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CiSessionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CookieShop\Models\CiSession) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CiSessionTableMap::DATABASE_NAME);
            $criteria->add(CiSessionTableMap::COL_SESSION_ID, (array) $values, Criteria::IN);
        }

        $query = CiSessionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CiSessionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CiSessionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ci_sessions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CiSessionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CiSession or Criteria object.
     *
     * @param mixed               $criteria Criteria or CiSession object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CiSessionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CiSession object
        }


        // Set the correct dbName
        $query = CiSessionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CiSessionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CiSessionTableMap::buildTableMap();
