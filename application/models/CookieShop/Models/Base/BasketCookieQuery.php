<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\BasketCookie as ChildBasketCookie;
use CookieShop\Models\BasketCookieQuery as ChildBasketCookieQuery;
use CookieShop\Models\Map\BasketCookieTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'basket_cookie' table.
 *
 *
 *
 * @method     ChildBasketCookieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBasketCookieQuery orderByBasketId($order = Criteria::ASC) Order by the basket_id column
 * @method     ChildBasketCookieQuery orderByCookieId($order = Criteria::ASC) Order by the cookie_id column
 * @method     ChildBasketCookieQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildBasketCookieQuery orderBySortOrder($order = Criteria::ASC) Order by the sort_order column
 *
 * @method     ChildBasketCookieQuery groupById() Group by the id column
 * @method     ChildBasketCookieQuery groupByBasketId() Group by the basket_id column
 * @method     ChildBasketCookieQuery groupByCookieId() Group by the cookie_id column
 * @method     ChildBasketCookieQuery groupByQuantity() Group by the quantity column
 * @method     ChildBasketCookieQuery groupBySortOrder() Group by the sort_order column
 *
 * @method     ChildBasketCookieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBasketCookieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBasketCookieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBasketCookieQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBasketCookieQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBasketCookieQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBasketCookieQuery leftJoinBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the Basket relation
 * @method     ChildBasketCookieQuery rightJoinBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Basket relation
 * @method     ChildBasketCookieQuery innerJoinBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the Basket relation
 *
 * @method     ChildBasketCookieQuery joinWithBasket($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Basket relation
 *
 * @method     ChildBasketCookieQuery leftJoinWithBasket() Adds a LEFT JOIN clause and with to the query using the Basket relation
 * @method     ChildBasketCookieQuery rightJoinWithBasket() Adds a RIGHT JOIN clause and with to the query using the Basket relation
 * @method     ChildBasketCookieQuery innerJoinWithBasket() Adds a INNER JOIN clause and with to the query using the Basket relation
 *
 * @method     ChildBasketCookieQuery leftJoinCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cookie relation
 * @method     ChildBasketCookieQuery rightJoinCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cookie relation
 * @method     ChildBasketCookieQuery innerJoinCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the Cookie relation
 *
 * @method     ChildBasketCookieQuery joinWithCookie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cookie relation
 *
 * @method     ChildBasketCookieQuery leftJoinWithCookie() Adds a LEFT JOIN clause and with to the query using the Cookie relation
 * @method     ChildBasketCookieQuery rightJoinWithCookie() Adds a RIGHT JOIN clause and with to the query using the Cookie relation
 * @method     ChildBasketCookieQuery innerJoinWithCookie() Adds a INNER JOIN clause and with to the query using the Cookie relation
 *
 * @method     \CookieShop\Models\BasketQuery|\CookieShop\Models\CookieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBasketCookie findOne(ConnectionInterface $con = null) Return the first ChildBasketCookie matching the query
 * @method     ChildBasketCookie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBasketCookie matching the query, or a new ChildBasketCookie object populated from the query conditions when no match is found
 *
 * @method     ChildBasketCookie findOneById(int $id) Return the first ChildBasketCookie filtered by the id column
 * @method     ChildBasketCookie findOneByBasketId(int $basket_id) Return the first ChildBasketCookie filtered by the basket_id column
 * @method     ChildBasketCookie findOneByCookieId(int $cookie_id) Return the first ChildBasketCookie filtered by the cookie_id column
 * @method     ChildBasketCookie findOneByQuantity(int $quantity) Return the first ChildBasketCookie filtered by the quantity column
 * @method     ChildBasketCookie findOneBySortOrder(int $sort_order) Return the first ChildBasketCookie filtered by the sort_order column *

 * @method     ChildBasketCookie requirePk($key, ConnectionInterface $con = null) Return the ChildBasketCookie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasketCookie requireOne(ConnectionInterface $con = null) Return the first ChildBasketCookie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBasketCookie requireOneById(int $id) Return the first ChildBasketCookie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasketCookie requireOneByBasketId(int $basket_id) Return the first ChildBasketCookie filtered by the basket_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasketCookie requireOneByCookieId(int $cookie_id) Return the first ChildBasketCookie filtered by the cookie_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasketCookie requireOneByQuantity(int $quantity) Return the first ChildBasketCookie filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasketCookie requireOneBySortOrder(int $sort_order) Return the first ChildBasketCookie filtered by the sort_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBasketCookie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBasketCookie objects based on current ModelCriteria
 * @method     ChildBasketCookie[]|ObjectCollection findById(int $id) Return ChildBasketCookie objects filtered by the id column
 * @method     ChildBasketCookie[]|ObjectCollection findByBasketId(int $basket_id) Return ChildBasketCookie objects filtered by the basket_id column
 * @method     ChildBasketCookie[]|ObjectCollection findByCookieId(int $cookie_id) Return ChildBasketCookie objects filtered by the cookie_id column
 * @method     ChildBasketCookie[]|ObjectCollection findByQuantity(int $quantity) Return ChildBasketCookie objects filtered by the quantity column
 * @method     ChildBasketCookie[]|ObjectCollection findBySortOrder(int $sort_order) Return ChildBasketCookie objects filtered by the sort_order column
 * @method     ChildBasketCookie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BasketCookieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\BasketCookieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\BasketCookie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBasketCookieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBasketCookieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBasketCookieQuery) {
            return $criteria;
        }
        $query = new ChildBasketCookieQuery();
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
     * @return ChildBasketCookie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BasketCookieTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BasketCookieTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBasketCookie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, basket_id, cookie_id, quantity, sort_order FROM basket_cookie WHERE id = :p0';
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
            /** @var ChildBasketCookie $obj */
            $obj = new ChildBasketCookie();
            $obj->hydrate($row);
            BasketCookieTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBasketCookie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BasketCookieTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BasketCookieTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookieTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the basket_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBasketId(1234); // WHERE basket_id = 1234
     * $query->filterByBasketId(array(12, 34)); // WHERE basket_id IN (12, 34)
     * $query->filterByBasketId(array('min' => 12)); // WHERE basket_id > 12
     * </code>
     *
     * @see       filterByBasket()
     *
     * @param     mixed $basketId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByBasketId($basketId = null, $comparison = null)
    {
        if (is_array($basketId)) {
            $useMinMax = false;
            if (isset($basketId['min'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_BASKET_ID, $basketId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basketId['max'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_BASKET_ID, $basketId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookieTableMap::COL_BASKET_ID, $basketId, $comparison);
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
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByCookieId($cookieId = null, $comparison = null)
    {
        if (is_array($cookieId)) {
            $useMinMax = false;
            if (isset($cookieId['min'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_COOKIE_ID, $cookieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cookieId['max'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_COOKIE_ID, $cookieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookieTableMap::COL_COOKIE_ID, $cookieId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookieTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the sort_order column
     *
     * Example usage:
     * <code>
     * $query->filterBySortOrder(1234); // WHERE sort_order = 1234
     * $query->filterBySortOrder(array(12, 34)); // WHERE sort_order IN (12, 34)
     * $query->filterBySortOrder(array('min' => 12)); // WHERE sort_order > 12
     * </code>
     *
     * @param     mixed $sortOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterBySortOrder($sortOrder = null, $comparison = null)
    {
        if (is_array($sortOrder)) {
            $useMinMax = false;
            if (isset($sortOrder['min'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_SORT_ORDER, $sortOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortOrder['max'])) {
                $this->addUsingAlias(BasketCookieTableMap::COL_SORT_ORDER, $sortOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookieTableMap::COL_SORT_ORDER, $sortOrder, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\Basket object
     *
     * @param \CookieShop\Models\Basket|ObjectCollection $basket The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByBasket($basket, $comparison = null)
    {
        if ($basket instanceof \CookieShop\Models\Basket) {
            return $this
                ->addUsingAlias(BasketCookieTableMap::COL_BASKET_ID, $basket->getId(), $comparison);
        } elseif ($basket instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BasketCookieTableMap::COL_BASKET_ID, $basket->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBasket() only accepts arguments of type \CookieShop\Models\Basket or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Basket relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function joinBasket($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Basket');

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
            $this->addJoinObject($join, 'Basket');
        }

        return $this;
    }

    /**
     * Use the Basket relation Basket object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\BasketQuery A secondary query class using the current class as primary query
     */
    public function useBasketQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBasket($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Basket', '\CookieShop\Models\BasketQuery');
    }

    /**
     * Filter the query by a related \CookieShop\Models\Cookie object
     *
     * @param \CookieShop\Models\Cookie|ObjectCollection $cookie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBasketCookieQuery The current query, for fluid interface
     */
    public function filterByCookie($cookie, $comparison = null)
    {
        if ($cookie instanceof \CookieShop\Models\Cookie) {
            return $this
                ->addUsingAlias(BasketCookieTableMap::COL_COOKIE_ID, $cookie->getId(), $comparison);
        } elseif ($cookie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BasketCookieTableMap::COL_COOKIE_ID, $cookie->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
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
     * @param   ChildBasketCookie $basketCookie Object to remove from the list of results
     *
     * @return $this|ChildBasketCookieQuery The current query, for fluid interface
     */
    public function prune($basketCookie = null)
    {
        if ($basketCookie) {
            $this->addUsingAlias(BasketCookieTableMap::COL_ID, $basketCookie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the basket_cookie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BasketCookieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BasketCookieTableMap::clearInstancePool();
            BasketCookieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BasketCookieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BasketCookieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BasketCookieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BasketCookieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BasketCookieQuery
