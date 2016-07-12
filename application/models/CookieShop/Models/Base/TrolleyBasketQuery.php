<?php

namespace CookieShop\Models\Base;

use \Exception;
use \PDO;
use CookieShop\Models\TrolleyBasket as ChildTrolleyBasket;
use CookieShop\Models\TrolleyBasketQuery as ChildTrolleyBasketQuery;
use CookieShop\Models\Map\TrolleyBasketTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trolley_basket' table.
 *
 *
 *
 * @method     ChildTrolleyBasketQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTrolleyBasketQuery orderByTrolleyId($order = Criteria::ASC) Order by the trolley_id column
 * @method     ChildTrolleyBasketQuery orderByBasketId($order = Criteria::ASC) Order by the basket_id column
 *
 * @method     ChildTrolleyBasketQuery groupById() Group by the id column
 * @method     ChildTrolleyBasketQuery groupByTrolleyId() Group by the trolley_id column
 * @method     ChildTrolleyBasketQuery groupByBasketId() Group by the basket_id column
 *
 * @method     ChildTrolleyBasketQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTrolleyBasketQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTrolleyBasketQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTrolleyBasketQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTrolleyBasketQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTrolleyBasketQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTrolleyBasketQuery leftJoinTrolley($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trolley relation
 * @method     ChildTrolleyBasketQuery rightJoinTrolley($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trolley relation
 * @method     ChildTrolleyBasketQuery innerJoinTrolley($relationAlias = null) Adds a INNER JOIN clause to the query using the Trolley relation
 *
 * @method     ChildTrolleyBasketQuery joinWithTrolley($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Trolley relation
 *
 * @method     ChildTrolleyBasketQuery leftJoinWithTrolley() Adds a LEFT JOIN clause and with to the query using the Trolley relation
 * @method     ChildTrolleyBasketQuery rightJoinWithTrolley() Adds a RIGHT JOIN clause and with to the query using the Trolley relation
 * @method     ChildTrolleyBasketQuery innerJoinWithTrolley() Adds a INNER JOIN clause and with to the query using the Trolley relation
 *
 * @method     ChildTrolleyBasketQuery leftJoinBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the Basket relation
 * @method     ChildTrolleyBasketQuery rightJoinBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Basket relation
 * @method     ChildTrolleyBasketQuery innerJoinBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the Basket relation
 *
 * @method     ChildTrolleyBasketQuery joinWithBasket($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Basket relation
 *
 * @method     ChildTrolleyBasketQuery leftJoinWithBasket() Adds a LEFT JOIN clause and with to the query using the Basket relation
 * @method     ChildTrolleyBasketQuery rightJoinWithBasket() Adds a RIGHT JOIN clause and with to the query using the Basket relation
 * @method     ChildTrolleyBasketQuery innerJoinWithBasket() Adds a INNER JOIN clause and with to the query using the Basket relation
 *
 * @method     ChildTrolleyBasketQuery leftJoinTrolleyBasketCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the TrolleyBasketCookie relation
 * @method     ChildTrolleyBasketQuery rightJoinTrolleyBasketCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TrolleyBasketCookie relation
 * @method     ChildTrolleyBasketQuery innerJoinTrolleyBasketCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the TrolleyBasketCookie relation
 *
 * @method     ChildTrolleyBasketQuery joinWithTrolleyBasketCookie($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TrolleyBasketCookie relation
 *
 * @method     ChildTrolleyBasketQuery leftJoinWithTrolleyBasketCookie() Adds a LEFT JOIN clause and with to the query using the TrolleyBasketCookie relation
 * @method     ChildTrolleyBasketQuery rightJoinWithTrolleyBasketCookie() Adds a RIGHT JOIN clause and with to the query using the TrolleyBasketCookie relation
 * @method     ChildTrolleyBasketQuery innerJoinWithTrolleyBasketCookie() Adds a INNER JOIN clause and with to the query using the TrolleyBasketCookie relation
 *
 * @method     \CookieShop\Models\TrolleyQuery|\CookieShop\Models\BasketQuery|\CookieShop\Models\TrolleyBasketCookieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrolleyBasket findOne(ConnectionInterface $con = null) Return the first ChildTrolleyBasket matching the query
 * @method     ChildTrolleyBasket findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTrolleyBasket matching the query, or a new ChildTrolleyBasket object populated from the query conditions when no match is found
 *
 * @method     ChildTrolleyBasket findOneById(int $id) Return the first ChildTrolleyBasket filtered by the id column
 * @method     ChildTrolleyBasket findOneByTrolleyId(int $trolley_id) Return the first ChildTrolleyBasket filtered by the trolley_id column
 * @method     ChildTrolleyBasket findOneByBasketId(int $basket_id) Return the first ChildTrolleyBasket filtered by the basket_id column *

 * @method     ChildTrolleyBasket requirePk($key, ConnectionInterface $con = null) Return the ChildTrolleyBasket by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasket requireOne(ConnectionInterface $con = null) Return the first ChildTrolleyBasket matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolleyBasket requireOneById(int $id) Return the first ChildTrolleyBasket filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasket requireOneByTrolleyId(int $trolley_id) Return the first ChildTrolleyBasket filtered by the trolley_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrolleyBasket requireOneByBasketId(int $basket_id) Return the first ChildTrolleyBasket filtered by the basket_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrolleyBasket[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTrolleyBasket objects based on current ModelCriteria
 * @method     ChildTrolleyBasket[]|ObjectCollection findById(int $id) Return ChildTrolleyBasket objects filtered by the id column
 * @method     ChildTrolleyBasket[]|ObjectCollection findByTrolleyId(int $trolley_id) Return ChildTrolleyBasket objects filtered by the trolley_id column
 * @method     ChildTrolleyBasket[]|ObjectCollection findByBasketId(int $basket_id) Return ChildTrolleyBasket objects filtered by the basket_id column
 * @method     ChildTrolleyBasket[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TrolleyBasketQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \CookieShop\Models\Base\TrolleyBasketQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CookieShop\\Models\\TrolleyBasket', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTrolleyBasketQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTrolleyBasketQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTrolleyBasketQuery) {
            return $criteria;
        }
        $query = new ChildTrolleyBasketQuery();
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
     * @return ChildTrolleyBasket|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TrolleyBasketTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTrolleyBasket A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, trolley_id, basket_id FROM trolley_basket WHERE id = :p0';
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
            /** @var ChildTrolleyBasket $obj */
            $obj = new ChildTrolleyBasket();
            $obj->hydrate($row);
            TrolleyBasketTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTrolleyBasket|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the trolley_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrolleyId(1234); // WHERE trolley_id = 1234
     * $query->filterByTrolleyId(array(12, 34)); // WHERE trolley_id IN (12, 34)
     * $query->filterByTrolleyId(array('min' => 12)); // WHERE trolley_id > 12
     * </code>
     *
     * @see       filterByTrolley()
     *
     * @param     mixed $trolleyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByTrolleyId($trolleyId = null, $comparison = null)
    {
        if (is_array($trolleyId)) {
            $useMinMax = false;
            if (isset($trolleyId['min'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_TROLLEY_ID, $trolleyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trolleyId['max'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_TROLLEY_ID, $trolleyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketTableMap::COL_TROLLEY_ID, $trolleyId, $comparison);
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
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByBasketId($basketId = null, $comparison = null)
    {
        if (is_array($basketId)) {
            $useMinMax = false;
            if (isset($basketId['min'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_BASKET_ID, $basketId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basketId['max'])) {
                $this->addUsingAlias(TrolleyBasketTableMap::COL_BASKET_ID, $basketId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrolleyBasketTableMap::COL_BASKET_ID, $basketId, $comparison);
    }

    /**
     * Filter the query by a related \CookieShop\Models\Trolley object
     *
     * @param \CookieShop\Models\Trolley|ObjectCollection $trolley The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByTrolley($trolley, $comparison = null)
    {
        if ($trolley instanceof \CookieShop\Models\Trolley) {
            return $this
                ->addUsingAlias(TrolleyBasketTableMap::COL_TROLLEY_ID, $trolley->getId(), $comparison);
        } elseif ($trolley instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrolleyBasketTableMap::COL_TROLLEY_ID, $trolley->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function joinTrolley($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useTrolleyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrolley($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trolley', '\CookieShop\Models\TrolleyQuery');
    }

    /**
     * Filter the query by a related \CookieShop\Models\Basket object
     *
     * @param \CookieShop\Models\Basket|ObjectCollection $basket The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByBasket($basket, $comparison = null)
    {
        if ($basket instanceof \CookieShop\Models\Basket) {
            return $this
                ->addUsingAlias(TrolleyBasketTableMap::COL_BASKET_ID, $basket->getId(), $comparison);
        } elseif ($basket instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrolleyBasketTableMap::COL_BASKET_ID, $basket->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
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
     * Filter the query by a related \CookieShop\Models\TrolleyBasketCookie object
     *
     * @param \CookieShop\Models\TrolleyBasketCookie|ObjectCollection $trolleyBasketCookie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function filterByTrolleyBasketCookie($trolleyBasketCookie, $comparison = null)
    {
        if ($trolleyBasketCookie instanceof \CookieShop\Models\TrolleyBasketCookie) {
            return $this
                ->addUsingAlias(TrolleyBasketTableMap::COL_ID, $trolleyBasketCookie->getTrolleyBasketId(), $comparison);
        } elseif ($trolleyBasketCookie instanceof ObjectCollection) {
            return $this
                ->useTrolleyBasketCookieQuery()
                ->filterByPrimaryKeys($trolleyBasketCookie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrolleyBasketCookie() only accepts arguments of type \CookieShop\Models\TrolleyBasketCookie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TrolleyBasketCookie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function joinTrolleyBasketCookie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TrolleyBasketCookie');

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
            $this->addJoinObject($join, 'TrolleyBasketCookie');
        }

        return $this;
    }

    /**
     * Use the TrolleyBasketCookie relation TrolleyBasketCookie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CookieShop\Models\TrolleyBasketCookieQuery A secondary query class using the current class as primary query
     */
    public function useTrolleyBasketCookieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrolleyBasketCookie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TrolleyBasketCookie', '\CookieShop\Models\TrolleyBasketCookieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTrolleyBasket $trolleyBasket Object to remove from the list of results
     *
     * @return $this|ChildTrolleyBasketQuery The current query, for fluid interface
     */
    public function prune($trolleyBasket = null)
    {
        if ($trolleyBasket) {
            $this->addUsingAlias(TrolleyBasketTableMap::COL_ID, $trolleyBasket->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trolley_basket table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TrolleyBasketTableMap::clearInstancePool();
            TrolleyBasketTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TrolleyBasketTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TrolleyBasketTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TrolleyBasketTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TrolleyBasketTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TrolleyBasketQuery
