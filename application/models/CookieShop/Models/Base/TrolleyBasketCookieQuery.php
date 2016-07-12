<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\TrolleyBasketCookie as ChildTrolleyBasketCookie;
use CookieShop\Models\TrolleyBasketCookieQuery as ChildTrolleyBasketCookieQuery;
use CookieShop\Models\Map\TrolleyBasketCookieTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trolley_basket_cookie' table.
 *
 *
 *
 * @method     ChildTrolleyBasketCookieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTrolleyBasketCookieQuery orderByTrolleyBasketId($order = Criteria::ASC) Order by the trolley_basket_id column
 * @method     ChildTrolleyBasketCookieQuery orderByCookieId($order = Criteria::ASC) Order by the cookie_id column
 *
 * @method     ChildTrolleyBasketCookieQuery groupById() Group by the id column
 * @method     ChildTrolleyBasketCookieQuery groupByTrolleyBasketId() Group by the trolley_basket_id column
 * @method     ChildTrolleyBasketCookieQuery groupByCookieId() Group by the cookie_id column
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTrolleyBasketCookieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTrolleyBasketCookieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTrolleyBasketCookieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTrolleyBasketCookieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoinTrolleyBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildTrolleyBasketCookieQuery rightJoinTrolleyBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildTrolleyBasketCookieQuery innerJoinTrolleyBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the TrolleyBasket relation
 *
 * @method     ChildTrolleyBasketCookieQuery joinWithTrolleyBasket($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TrolleyBasket relation
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoinWithTrolleyBasket() Adds a LEFT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildTrolleyBasketCookieQuery rightJoinWithTrolleyBasket() Adds a RIGHT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildTrolleyBasketCookieQuery innerJoinWithTrolleyBasket() Adds a INNER JOIN clause and with to the query using the TrolleyBasket relation
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoinCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cookie relation
 * @method     ChildTrolleyBasketCookieQuery rightJoinCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cookie relation
 * @method     ChildTrolleyBasketCookieQuery innerJoinCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the Cookie relation
 *
 * @method     ChildTrolleyBasketCookieQuery joinWithCookie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cookie relation
 *
 * @method     ChildTrolleyBasketCookieQuery leftJoinWithCookie() Adds a LEFT JOIN clause and with to the query using the Cookie relation
 * @method     ChildTrolleyBasketCookieQuery rightJoinWithCookie() Adds a RIGHT JOIN clause and with to the query using the Cookie relation
 * @method     ChildTrolleyBasketCookieQuery innerJoinWithCookie() Adds a INNER JOIN clause and with to the query using the Cookie relation
 *
 * @method     \CookieShop\Models\TrolleyBasketQuery|\CookieShop\Models\CookieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrolleyBasketCookie findOne(ConnectionInterface $con = null) Return the first ChildTrolleyBasketCookie matching the query
 * @method     ChildTrolleyBasketCookie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTrolleyBasketCookie matching the query, or a new ChildTrolleyBasketCookie object populated from the query conditions when no match is found
 *
 * @method     ChildTrolleyBasketCookie findOneById(int $id) Return the first ChildTrolleyBasketCookie filtered by the id column
 * @method     ChildTrolleyBasketCookie findOneByTrolleyBasketId(int $trolley_basket_id) Return the first ChildTrolleyBasketCookie filtered by the trolley_basket_id column
 * @method     ChildTrolleyBasketCookie findOneByCookieId(int $cookie_id) Return the first ChildTrolleyBasketCookie filtered by the cookie_id column *

 * @method     ChildTrolleyBasketCookie requirePk($key, ConnectionInterface $con = null) Return the ChildTrolleyBasketCookie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasketCookie requireOne(ConnectionInterface $con = null) Return the first ChildTrolleyBasketCookie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolleyBasketCookie requireOneById(int $id) Return the first ChildTrolleyBasketCookie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasketCookie requireOneByTrolleyBasketId(int $trolley_basket_id) Return the first ChildTrolleyBasketCookie filtered by the trolley_basket_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasketCookie requireOneByCookieId(int $cookie_id) Return the first ChildTrolleyBasketCookie filtered by the cookie_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolleyBasketCookie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTrolleyBasketCookie objects based on current ModelCriteria
 * @method     ChildTrolleyBasketCookie[]|ObjectCollection findById(int $id) Return ChildTrolleyBasketCookie objects filtered by the id column
 * @method     ChildTrolleyBasketCookie[]|ObjectCollection findByTrolleyBasketId(int $trolley_basket_id) Return ChildTrolleyBasketCookie objects filtered by the trolley_basket_id column
 * @method     ChildTrolleyBasketCookie[]|ObjectCollection findByCookieId(int $cookie_id) Return ChildTrolleyBasketCookie objects filtered by the cookie_id column
 * @method     ChildTrolleyBasketCookie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TrolleyBasketCookieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\TrolleyBasketCookieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\TrolleyBasketCookie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTrolleyBasketCookieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTrolleyBasketCookieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTrolleyBasketCookieQuery) {
            return $criteria;
        }
        $query = new ChildTrolleyBasketCookieQuery();
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
     * @return ChildTrolleyBasketCookie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrolleyBasketCookieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TrolleyBasketCookieTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTrolleyBasketCookie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, trolley_basket_id, cookie_id FROM trolley_basket_cookie WHERE id = :p0';
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
            /** @var ChildTrolleyBasketCookie $obj */
            $obj = new ChildTrolleyBasketCookie();
            $obj->hydrate($row);
            TrolleyBasketCookieTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTrolleyBasketCookie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the trolley_basket_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrolleyBasketId(1234); // WHERE trolley_basket_id = 1234
     * $query->filterByTrolleyBasketId(array(12, 34)); // WHERE trolley_basket_id IN (12, 34)
     * $query->filterByTrolleyBasketId(array('min' => 12)); // WHERE trolley_basket_id > 12
     * </code>
     *
     * @see       filterByTrolleyBasket()
     *
     * @param     mixed $trolleyBasketId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByTrolleyBasketId($trolleyBasketId = null, $comparison = null)
    {
        if (is_array($trolleyBasketId)) {
            $useMinMax = false;
            if (isset($trolleyBasketId['min'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_TROLLEY_BASKET_ID, $trolleyBasketId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trolleyBasketId['max'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_TROLLEY_BASKET_ID, $trolleyBasketId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_TROLLEY_BASKET_ID, $trolleyBasketId, $comparison);
    }

    /**
     * Filter the query on the cookie_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCookieId(1234); // WHERE cookie_id = 1234
     * $query->filterByCookieId(array(12, 34)); // WHERE cookie_id IN (12, 34)
     * $query->filterByCookieId(array('min' => 12)); // WHERE cookie_id > 12
     * </code>
     *
     * @see       filterByCookie()
     *
     * @param     mixed $cookieId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByCookieId($cookieId = null, $comparison = null)
    {
        if (is_array($cookieId)) {
            $useMinMax = false;
            if (isset($cookieId['min'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_COOKIE_ID, $cookieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cookieId['max'])) {
                $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_COOKIE_ID, $cookieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_COOKIE_ID, $cookieId, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\TrolleyBasket object
     *
     * @param \CookieShop\Models\TrolleyBasket|ObjectCollection $trolleyBasket The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByTrolleyBasket($trolleyBasket, $comparison = null)
    {
        if ($trolleyBasket instanceof \CookieShop\Models\TrolleyBasket) {
            return $this
                ->addUsingAlias(TrolleyBasketCookieTableMap::COL_TROLLEY_BASKET_ID, $trolleyBasket->getId(), $comparison);
        } elseif ($trolleyBasket instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrolleyBasketCookieTableMap::COL_TROLLEY_BASKET_ID, $trolleyBasket->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
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
     * Filter the query by a related \CookieShop\Models\Cookie object
     *
     * @param \CookieShop\Models\Cookie|ObjectCollection $cookie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function filterByCookie($cookie, $comparison = null)
    {
        if ($cookie instanceof \CookieShop\Models\Cookie) {
            return $this
                ->addUsingAlias(TrolleyBasketCookieTableMap::COL_COOKIE_ID, $cookie->getId(), $comparison);
        } elseif ($cookie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrolleyBasketCookieTableMap::COL_COOKIE_ID, $cookie->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCookie() only accepts arguments of type \CookieShop\Models\Cookie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cookie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function joinCookie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cookie');

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
            $this->addJoinObject($join, 'Cookie');
        }

        return $this;
    }

    /**
     * Use the Cookie relation Cookie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\CookieQuery A secondary query class using the current class as primary query
     */
    public function useCookieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCookie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cookie', '\CookieShop\Models\CookieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTrolleyBasketCookie $trolleyBasketCookie Object to remove from the list of results
     *
     * @return $this|ChildTrolleyBasketCookieQuery The current query, for fluid interface
     */
    public function prune($trolleyBasketCookie = null)
    {
        if ($trolleyBasketCookie) {
            $this->addUsingAlias(TrolleyBasketCookieTableMap::COL_ID, $trolleyBasketCookie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trolley_basket_cookie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketCookieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TrolleyBasketCookieTableMap::clearInstancePool();
            TrolleyBasketCookieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketCookieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TrolleyBasketCookieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TrolleyBasketCookieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TrolleyBasketCookieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TrolleyBasketCookieQuery
