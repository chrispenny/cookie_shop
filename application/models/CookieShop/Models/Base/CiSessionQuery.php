<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\CiSession as ChildCiSession;
use CookieShop\Models\CiSessionQuery as ChildCiSessionQuery;
use CookieShop\Models\Map\CiSessionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ci_sessions' table.
 *
 *
 *
 * @method     ChildCiSessionQuery orderBySessionId($order = Criteria::ASC) Order by the session_id column
 * @method     ChildCiSessionQuery orderByIpAddress($order = Criteria::ASC) Order by the ip_address column
 * @method     ChildCiSessionQuery orderByUserAgent($order = Criteria::ASC) Order by the user_agent column
 * @method     ChildCiSessionQuery orderByLastActivity($order = Criteria::ASC) Order by the last_activity column
 * @method     ChildCiSessionQuery orderByUserData($order = Criteria::ASC) Order by the user_data column
 *
 * @method     ChildCiSessionQuery groupBySessionId() Group by the session_id column
 * @method     ChildCiSessionQuery groupByIpAddress() Group by the ip_address column
 * @method     ChildCiSessionQuery groupByUserAgent() Group by the user_agent column
 * @method     ChildCiSessionQuery groupByLastActivity() Group by the last_activity column
 * @method     ChildCiSessionQuery groupByUserData() Group by the user_data column
 *
 * @method     ChildCiSessionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCiSessionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCiSessionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCiSessionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCiSessionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCiSessionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCiSessionQuery leftJoinTrolley($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trolley relation
 * @method     ChildCiSessionQuery rightJoinTrolley($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trolley relation
 * @method     ChildCiSessionQuery innerJoinTrolley($relationAlias = null) Adds a INNER JOIN clause to the query using the Trolley relation
 *
 * @method     ChildCiSessionQuery joinWithTrolley($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Trolley relation
 *
 * @method     ChildCiSessionQuery leftJoinWithTrolley() Adds a LEFT JOIN clause and with to the query using the Trolley relation
 * @method     ChildCiSessionQuery rightJoinWithTrolley() Adds a RIGHT JOIN clause and with to the query using the Trolley relation
 * @method     ChildCiSessionQuery innerJoinWithTrolley() Adds a INNER JOIN clause and with to the query using the Trolley relation
 *
 * @method     \CookieShop\Models\TrolleyQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCiSession findOne(ConnectionInterface $con = null) Return the first ChildCiSession matching the query
 * @method     ChildCiSession findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCiSession matching the query, or a new ChildCiSession object populated from the query conditions when no match is found
 *
 * @method     ChildCiSession findOneBySessionId(string $session_id) Return the first ChildCiSession filtered by the session_id column
 * @method     ChildCiSession findOneByIpAddress(string $ip_address) Return the first ChildCiSession filtered by the ip_address column
 * @method     ChildCiSession findOneByUserAgent(string $user_agent) Return the first ChildCiSession filtered by the user_agent column
 * @method     ChildCiSession findOneByLastActivity(int $last_activity) Return the first ChildCiSession filtered by the last_activity column
 * @method     ChildCiSession findOneByUserData(string $user_data) Return the first ChildCiSession filtered by the user_data column *

 * @method     ChildCiSession requirePk($key, ConnectionInterface $con = null) Return the ChildCiSession by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCiSession requireOne(ConnectionInterface $con = null) Return the first ChildCiSession matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCiSession requireOneBySessionId(string $session_id) Return the first ChildCiSession filtered by the session_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCiSession requireOneByIpAddress(string $ip_address) Return the first ChildCiSession filtered by the ip_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCiSession requireOneByUserAgent(string $user_agent) Return the first ChildCiSession filtered by the user_agent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCiSession requireOneByLastActivity(int $last_activity) Return the first ChildCiSession filtered by the last_activity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCiSession requireOneByUserData(string $user_data) Return the first ChildCiSession filtered by the user_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCiSession[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCiSession objects based on current ModelCriteria
 * @method     ChildCiSession[]|ObjectCollection findBySessionId(string $session_id) Return ChildCiSession objects filtered by the session_id column
 * @method     ChildCiSession[]|ObjectCollection findByIpAddress(string $ip_address) Return ChildCiSession objects filtered by the ip_address column
 * @method     ChildCiSession[]|ObjectCollection findByUserAgent(string $user_agent) Return ChildCiSession objects filtered by the user_agent column
 * @method     ChildCiSession[]|ObjectCollection findByLastActivity(int $last_activity) Return ChildCiSession objects filtered by the last_activity column
 * @method     ChildCiSession[]|ObjectCollection findByUserData(string $user_data) Return ChildCiSession objects filtered by the user_data column
 * @method     ChildCiSession[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CiSessionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\CiSessionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\CiSession', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCiSessionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCiSessionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCiSessionQuery) {
            return $criteria;
        }
        $query = new ChildCiSessionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCiSession|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CiSessionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CiSessionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCiSession A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT session_id, ip_address, user_agent, last_activity, user_data FROM ci_sessions WHERE session_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCiSession $obj */
            $obj = new ChildCiSession();
            $obj->hydrate($row);
            CiSessionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCiSession|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CiSessionTableMap::COL_SESSION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CiSessionTableMap::COL_SESSION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the session_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySessionId('fooValue');   // WHERE session_id = 'fooValue'
     * $query->filterBySessionId('%fooValue%'); // WHERE session_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sessionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterBySessionId($sessionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sessionId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CiSessionTableMap::COL_SESSION_ID, $sessionId, $comparison);
    }

    /**
     * Filter the query on the ip_address column
     *
     * Example usage:
     * <code>
     * $query->filterByIpAddress('fooValue');   // WHERE ip_address = 'fooValue'
     * $query->filterByIpAddress('%fooValue%'); // WHERE ip_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ipAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByIpAddress($ipAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ipAddress)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CiSessionTableMap::COL_IP_ADDRESS, $ipAddress, $comparison);
    }

    /**
     * Filter the query on the user_agent column
     *
     * Example usage:
     * <code>
     * $query->filterByUserAgent('fooValue');   // WHERE user_agent = 'fooValue'
     * $query->filterByUserAgent('%fooValue%'); // WHERE user_agent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userAgent The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByUserAgent($userAgent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userAgent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CiSessionTableMap::COL_USER_AGENT, $userAgent, $comparison);
    }

    /**
     * Filter the query on the last_activity column
     *
     * Example usage:
     * <code>
     * $query->filterByLastActivity(1234); // WHERE last_activity = 1234
     * $query->filterByLastActivity(array(12, 34)); // WHERE last_activity IN (12, 34)
     * $query->filterByLastActivity(array('min' => 12)); // WHERE last_activity > 12
     * </code>
     *
     * @param     mixed $lastActivity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByLastActivity($lastActivity = null, $comparison = null)
    {
        if (is_array($lastActivity)) {
            $useMinMax = false;
            if (isset($lastActivity['min'])) {
                $this->addUsingAlias(CiSessionTableMap::COL_LAST_ACTIVITY, $lastActivity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastActivity['max'])) {
                $this->addUsingAlias(CiSessionTableMap::COL_LAST_ACTIVITY, $lastActivity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CiSessionTableMap::COL_LAST_ACTIVITY, $lastActivity, $comparison);
    }

    /**
     * Filter the query on the user_data column
     *
     * Example usage:
     * <code>
     * $query->filterByUserData('fooValue');   // WHERE user_data = 'fooValue'
     * $query->filterByUserData('%fooValue%'); // WHERE user_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userData The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByUserData($userData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CiSessionTableMap::COL_USER_DATA, $userData, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\Trolley object
     *
     * @param \CookieShop\Models\Trolley|ObjectCollection $trolley the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCiSessionQuery The current query, for fluid interface
     */
    public function filterByTrolley($trolley, $comparison = null)
    {
        if ($trolley instanceof \CookieShop\Models\Trolley) {
            return $this
                ->addUsingAlias(CiSessionTableMap::COL_SESSION_ID, $trolley->getCiSessionId(), $comparison);
        } elseif ($trolley instanceof ObjectCollection) {
            return $this
                ->useTrolleyQuery()
                ->filterByPrimaryKeys($trolley->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrolley() only accepts arguments of type \CookieShop\Models\Trolley or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trolley relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function joinTrolley($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Trolley');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Trolley');
        }

        return $this;
    }

    /**
     * Use the Trolley relation Trolley object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\TrolleyQuery A secondary query class using the current class as primary query
     */
    public function useTrolleyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTrolley($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trolley', '\CookieShop\Models\TrolleyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCiSession $ciSession Object to remove from the list of results
     *
     * @return $this|ChildCiSessionQuery The current query, for fluid interface
     */
    public function prune($ciSession = null)
    {
        if ($ciSession) {
            $this->addUsingAlias(CiSessionTableMap::COL_SESSION_ID, $ciSession->getSessionId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ci_sessions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CiSessionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CiSessionTableMap::clearInstancePool();
            CiSessionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CiSessionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CiSessionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CiSessionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CiSessionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CiSessionQuery
