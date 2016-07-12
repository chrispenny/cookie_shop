<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\Trolley as ChildTrolley;
use CookieShop\Models\TrolleyQuery as ChildTrolleyQuery;
use CookieShop\Models\Map\TrolleyTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trolley' table.
 *
 *
 *
 * @method     ChildTrolleyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTrolleyQuery orderByCiSessionId($order = Criteria::ASC) Order by the ci_session_id column
 * @method     ChildTrolleyQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildTrolleyQuery orderByLastModified($order = Criteria::ASC) Order by the last_modified column
 *
 * @method     ChildTrolleyQuery groupById() Group by the id column
 * @method     ChildTrolleyQuery groupByCiSessionId() Group by the ci_session_id column
 * @method     ChildTrolleyQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildTrolleyQuery groupByLastModified() Group by the last_modified column
 *
 * @method     ChildTrolleyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTrolleyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTrolleyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTrolleyQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTrolleyQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTrolleyQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTrolleyQuery leftJoinCiSession($relationAlias = null) Adds a LEFT JOIN clause to the query using the CiSession relation
 * @method     ChildTrolleyQuery rightJoinCiSession($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CiSession relation
 * @method     ChildTrolleyQuery innerJoinCiSession($relationAlias = null) Adds a INNER JOIN clause to the query using the CiSession relation
 *
 * @method     ChildTrolleyQuery joinWithCiSession($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CiSession relation
 *
 * @method     ChildTrolleyQuery leftJoinWithCiSession() Adds a LEFT JOIN clause and with to the query using the CiSession relation
 * @method     ChildTrolleyQuery rightJoinWithCiSession() Adds a RIGHT JOIN clause and with to the query using the CiSession relation
 * @method     ChildTrolleyQuery innerJoinWithCiSession() Adds a INNER JOIN clause and with to the query using the CiSession relation
 *
 * @method     ChildTrolleyQuery leftJoinTrolleyBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildTrolleyQuery rightJoinTrolleyBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildTrolleyQuery innerJoinTrolleyBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the TrolleyBasket relation
 *
 * @method     ChildTrolleyQuery joinWithTrolleyBasket($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TrolleyBasket relation
 *
 * @method     ChildTrolleyQuery leftJoinWithTrolleyBasket() Adds a LEFT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildTrolleyQuery rightJoinWithTrolleyBasket() Adds a RIGHT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildTrolleyQuery innerJoinWithTrolleyBasket() Adds a INNER JOIN clause and with to the query using the TrolleyBasket relation
 *
 * @method     \CookieShop\Models\CiSessionQuery|\CookieShop\Models\TrolleyBasketQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrolley findOne(ConnectionInterface $con = null) Return the first ChildTrolley matching the query
 * @method     ChildTrolley findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTrolley matching the query, or a new ChildTrolley object populated from the query conditions when no match is found
 *
 * @method     ChildTrolley findOneById(int $id) Return the first ChildTrolley filtered by the id column
 * @method     ChildTrolley findOneByCiSessionId(string $ci_session_id) Return the first ChildTrolley filtered by the ci_session_id column
 * @method     ChildTrolley findOneByCustomerId(int $customer_id) Return the first ChildTrolley filtered by the customer_id column
 * @method     ChildTrolley findOneByLastModified(string $last_modified) Return the first ChildTrolley filtered by the last_modified column *

 * @method     ChildTrolley requirePk($key, ConnectionInterface $con = null) Return the ChildTrolley by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolley requireOne(ConnectionInterface $con = null) Return the first ChildTrolley matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolley requireOneById(int $id) Return the first ChildTrolley filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolley requireOneByCiSessionId(string $ci_session_id) Return the first ChildTrolley filtered by the ci_session_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolley requireOneByCustomerId(int $customer_id) Return the first ChildTrolley filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolley requireOneByLastModified(string $last_modified) Return the first ChildTrolley filtered by the last_modified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolley[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTrolley objects based on current ModelCriteria
 * @method     ChildTrolley[]|ObjectCollection findById(int $id) Return ChildTrolley objects filtered by the id column
 * @method     ChildTrolley[]|ObjectCollection findByCiSessionId(string $ci_session_id) Return ChildTrolley objects filtered by the ci_session_id column
 * @method     ChildTrolley[]|ObjectCollection findByCustomerId(int $customer_id) Return ChildTrolley objects filtered by the customer_id column
 * @method     ChildTrolley[]|ObjectCollection findByLastModified(string $last_modified) Return ChildTrolley objects filtered by the last_modified column
 * @method     ChildTrolley[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TrolleyQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\TrolleyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\Trolley', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTrolleyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTrolleyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTrolleyQuery) {
            return $criteria;
        }
        $query = new ChildTrolleyQuery();
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
     * @return ChildTrolley|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrolleyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TrolleyTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTrolley A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ci_session_id, customer_id, last_modified FROM trolley WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTrolley $obj */
            $obj = new ChildTrolley();
            $obj->hydrate($row);
            TrolleyTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTrolley|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TrolleyTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TrolleyTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the ci_session_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCiSessionId('fooValue');   // WHERE ci_session_id = 'fooValue'
     * $query->filterByCiSessionId('%fooValue%'); // WHERE ci_session_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ciSessionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByCiSessionId($ciSessionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ciSessionId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyTableMap::COL_CI_SESSION_ID, $ciSessionId, $comparison);
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
     * </code>
     *
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyTableMap::COL_CUSTOMER_ID, $customerId, $comparison);
    }

    /**
     * Filter the query on the last_modified column
     *
     * Example usage:
     * <code>
     * $query->filterByLastModified('2011-03-14'); // WHERE last_modified = '2011-03-14'
     * $query->filterByLastModified('now'); // WHERE last_modified = '2011-03-14'
     * $query->filterByLastModified(array('max' => 'yesterday')); // WHERE last_modified > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastModified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByLastModified($lastModified = null, $comparison = null)
    {
        if (is_array($lastModified)) {
            $useMinMax = false;
            if (isset($lastModified['min'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_LAST_MODIFIED, $lastModified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastModified['max'])) {
                $this->addUsingAlias(TrolleyTableMap::COL_LAST_MODIFIED, $lastModified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyTableMap::COL_LAST_MODIFIED, $lastModified, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\CiSession object
     *
     * @param \CookieShop\Models\CiSession|ObjectCollection $ciSession The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByCiSession($ciSession, $comparison = null)
    {
        if ($ciSession instanceof \CookieShop\Models\CiSession) {
            return $this
                ->addUsingAlias(TrolleyTableMap::COL_CI_SESSION_ID, $ciSession->getSessionId(), $comparison);
        } elseif ($ciSession instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrolleyTableMap::COL_CI_SESSION_ID, $ciSession->toKeyValue('PrimaryKey', 'SessionId'), $comparison);
        } else {
            throw new PropelException('filterByCiSession() only accepts arguments of type \CookieShop\Models\CiSession or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CiSession relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function joinCiSession($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CiSession');

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
            $this->addJoinObject($join, 'CiSession');
        }

        return $this;
    }

    /**
     * Use the CiSession relation CiSession object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\CiSessionQuery A secondary query class using the current class as primary query
     */
    public function useCiSessionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCiSession($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CiSession', '\CookieShop\Models\CiSessionQuery');
    }

    /**
     * Filter the query by a related \CookieShop\Models\TrolleyBasket object
     *
     * @param \CookieShop\Models\TrolleyBasket|ObjectCollection $trolleyBasket the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTrolleyQuery The current query, for fluid interface
     */
    public function filterByTrolleyBasket($trolleyBasket, $comparison = null)
    {
        if ($trolleyBasket instanceof \CookieShop\Models\TrolleyBasket) {
            return $this
                ->addUsingAlias(TrolleyTableMap::COL_ID, $trolleyBasket->getTrolleyId(), $comparison);
        } elseif ($trolleyBasket instanceof ObjectCollection) {
            return $this
                ->useTrolleyBasketQuery()
                ->filterByPrimaryKeys($trolleyBasket->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrolleyBasket() only accepts arguments of type \CookieShop\Models\TrolleyBasket or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TrolleyBasket relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function joinTrolleyBasket($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TrolleyBasket');

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
            $this->addJoinObject($join, 'TrolleyBasket');
        }

        return $this;
    }

    /**
     * Use the TrolleyBasket relation TrolleyBasket object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\TrolleyBasketQuery A secondary query class using the current class as primary query
     */
    public function useTrolleyBasketQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrolleyBasket($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TrolleyBasket', '\CookieShop\Models\TrolleyBasketQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTrolley $trolley Object to remove from the list of results
     *
     * @return $this|ChildTrolleyQuery The current query, for fluid interface
     */
    public function prune($trolley = null)
    {
        if ($trolley) {
            $this->addUsingAlias(TrolleyTableMap::COL_ID, $trolley->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trolley table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TrolleyTableMap::clearInstancePool();
            TrolleyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TrolleyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TrolleyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TrolleyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TrolleyQuery
