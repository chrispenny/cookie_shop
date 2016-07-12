<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\Basket as ChildBasket;
use CookieShop\Models\BasketQuery as ChildBasketQuery;
use CookieShop\Models\Map\BasketTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'basket' table.
 *
 *
 *
 * @method     ChildBasketQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBasketQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildBasketQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildBasketQuery orderBySize($order = Criteria::ASC) Order by the size column
 * @method     ChildBasketQuery orderBySortOrder($order = Criteria::ASC) Order by the sort_order column
 *
 * @method     ChildBasketQuery groupById() Group by the id column
 * @method     ChildBasketQuery groupByName() Group by the name column
 * @method     ChildBasketQuery groupByPrice() Group by the price column
 * @method     ChildBasketQuery groupBySize() Group by the size column
 * @method     ChildBasketQuery groupBySortOrder() Group by the sort_order column
 *
 * @method     ChildBasketQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBasketQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBasketQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBasketQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBasketQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBasketQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBasketQuery leftJoinBasketCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the BasketCookie relation
 * @method     ChildBasketQuery rightJoinBasketCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BasketCookie relation
 * @method     ChildBasketQuery innerJoinBasketCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the BasketCookie relation
 *
 * @method     ChildBasketQuery joinWithBasketCookie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BasketCookie relation
 *
 * @method     ChildBasketQuery leftJoinWithBasketCookie() Adds a LEFT JOIN clause and with to the query using the BasketCookie relation
 * @method     ChildBasketQuery rightJoinWithBasketCookie() Adds a RIGHT JOIN clause and with to the query using the BasketCookie relation
 * @method     ChildBasketQuery innerJoinWithBasketCookie() Adds a INNER JOIN clause and with to the query using the BasketCookie relation
 *
 * @method     ChildBasketQuery leftJoinTrolleyBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildBasketQuery rightJoinTrolleyBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TrolleyBasket relation
 * @method     ChildBasketQuery innerJoinTrolleyBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the TrolleyBasket relation
 *
 * @method     ChildBasketQuery joinWithTrolleyBasket($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TrolleyBasket relation
 *
 * @method     ChildBasketQuery leftJoinWithTrolleyBasket() Adds a LEFT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildBasketQuery rightJoinWithTrolleyBasket() Adds a RIGHT JOIN clause and with to the query using the TrolleyBasket relation
 * @method     ChildBasketQuery innerJoinWithTrolleyBasket() Adds a INNER JOIN clause and with to the query using the TrolleyBasket relation
 *
 * @method     \CookieShop\Models\BasketCookieQuery|\CookieShop\Models\TrolleyBasketQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBasket findOne(ConnectionInterface $con = null) Return the first ChildBasket matching the query
 * @method     ChildBasket findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBasket matching the query, or a new ChildBasket object populated from the query conditions when no match is found
 *
 * @method     ChildBasket findOneById(int $id) Return the first ChildBasket filtered by the id column
 * @method     ChildBasket findOneByName(string $name) Return the first ChildBasket filtered by the name column
 * @method     ChildBasket findOneByPrice(string $price) Return the first ChildBasket filtered by the price column
 * @method     ChildBasket findOneBySize(int $size) Return the first ChildBasket filtered by the size column
 * @method     ChildBasket findOneBySortOrder(int $sort_order) Return the first ChildBasket filtered by the sort_order column *

 * @method     ChildBasket requirePk($key, ConnectionInterface $con = null) Return the ChildBasket by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasket requireOne(ConnectionInterface $con = null) Return the first ChildBasket matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBasket requireOneById(int $id) Return the first ChildBasket filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasket requireOneByName(string $name) Return the first ChildBasket filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasket requireOneByPrice(string $price) Return the first ChildBasket filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasket requireOneBySize(int $size) Return the first ChildBasket filtered by the size column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBasket requireOneBySortOrder(int $sort_order) Return the first ChildBasket filtered by the sort_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBasket[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBasket objects based on current ModelCriteria
 * @method     ChildBasket[]|ObjectCollection findById(int $id) Return ChildBasket objects filtered by the id column
 * @method     ChildBasket[]|ObjectCollection findByName(string $name) Return ChildBasket objects filtered by the name column
 * @method     ChildBasket[]|ObjectCollection findByPrice(string $price) Return ChildBasket objects filtered by the price column
 * @method     ChildBasket[]|ObjectCollection findBySize(int $size) Return ChildBasket objects filtered by the size column
 * @method     ChildBasket[]|ObjectCollection findBySortOrder(int $sort_order) Return ChildBasket objects filtered by the sort_order column
 * @method     ChildBasket[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BasketQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\BasketQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\Basket', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBasketQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBasketQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBasketQuery) {
            return $criteria;
        }
        $query = new ChildBasketQuery();
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
     * @return ChildBasket|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BasketTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BasketTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBasket A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, price, size, sort_order FROM basket WHERE id = :p0';
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
            /** @var ChildBasket $obj */
            $obj = new ChildBasket();
            $obj->hydrate($row);
            BasketTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBasket|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BasketTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BasketTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BasketTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BasketTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(BasketTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(BasketTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the size column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE size = 1234
     * $query->filterBySize(array(12, 34)); // WHERE size IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE size > 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(BasketTableMap::COL_SIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(BasketTableMap::COL_SIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketTableMap::COL_SIZE, $size, $comparison);
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
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function filterBySortOrder($sortOrder = null, $comparison = null)
    {
        if (is_array($sortOrder)) {
            $useMinMax = false;
            if (isset($sortOrder['min'])) {
                $this->addUsingAlias(BasketTableMap::COL_SORT_ORDER, $sortOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortOrder['max'])) {
                $this->addUsingAlias(BasketTableMap::COL_SORT_ORDER, $sortOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketTableMap::COL_SORT_ORDER, $sortOrder, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\BasketCookie object
     *
     * @param \CookieShop\Models\BasketCookie|ObjectCollection $basketCookie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBasketQuery The current query, for fluid interface
     */
    public function filterByBasketCookie($basketCookie, $comparison = null)
    {
        if ($basketCookie instanceof \CookieShop\Models\BasketCookie) {
            return $this
                ->addUsingAlias(BasketTableMap::COL_ID, $basketCookie->getBasketId(), $comparison);
        } elseif ($basketCookie instanceof ObjectCollection) {
            return $this
                ->useBasketCookieQuery()
                ->filterByPrimaryKeys($basketCookie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBasketCookie() only accepts arguments of type \CookieShop\Models\BasketCookie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BasketCookie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function joinBasketCookie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BasketCookie');

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
            $this->addJoinObject($join, 'BasketCookie');
        }

        return $this;
    }

    /**
     * Use the BasketCookie relation BasketCookie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\BasketCookieQuery A secondary query class using the current class as primary query
     */
    public function useBasketCookieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBasketCookie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BasketCookie', '\CookieShop\Models\BasketCookieQuery');
    }

    /**
     * Filter the query by a related \CookieShop\Models\TrolleyBasket object
     *
     * @param \CookieShop\Models\TrolleyBasket|ObjectCollection $trolleyBasket the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBasketQuery The current query, for fluid interface
     */
    public function filterByTrolleyBasket($trolleyBasket, $comparison = null)
    {
        if ($trolleyBasket instanceof \CookieShop\Models\TrolleyBasket) {
            return $this
                ->addUsingAlias(BasketTableMap::COL_ID, $trolleyBasket->getBasketId(), $comparison);
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
     * @return $this|ChildBasketQuery The current query, for fluid interface
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
     * @param   ChildBasket $basket Object to remove from the list of results
     *
     * @return $this|ChildBasketQuery The current query, for fluid interface
     */
    public function prune($basket = null)
    {
        if ($basket) {
            $this->addUsingAlias(BasketTableMap::COL_ID, $basket->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the basket table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BasketTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BasketTableMap::clearInstancePool();
            BasketTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BasketTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BasketTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BasketTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BasketTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BasketQuery
