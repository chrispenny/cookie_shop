<?php

namespace CookieShop\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use CookieShop\Model\Basket;
use CookieShop\Model\BasketCookie;
use CookieShop\Model\BasketCookiePeer;
use CookieShop\Model\BasketCookieQuery;
use CookieShop\Model\Cookie;

/**
 * Base class that represents a query for the 'basket_cookie' table.
 *
 *
 *
 * @method BasketCookieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BasketCookieQuery orderByBasketId($order = Criteria::ASC) Order by the basket_id column
 * @method BasketCookieQuery orderByCookieId($order = Criteria::ASC) Order by the cookie_id column
 * @method BasketCookieQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method BasketCookieQuery orderBySortOrder($order = Criteria::ASC) Order by the sort_order column
 *
 * @method BasketCookieQuery groupById() Group by the id column
 * @method BasketCookieQuery groupByBasketId() Group by the basket_id column
 * @method BasketCookieQuery groupByCookieId() Group by the cookie_id column
 * @method BasketCookieQuery groupByQuantity() Group by the quantity column
 * @method BasketCookieQuery groupBySortOrder() Group by the sort_order column
 *
 * @method BasketCookieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BasketCookieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BasketCookieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BasketCookieQuery leftJoinCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cookie relation
 * @method BasketCookieQuery rightJoinCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cookie relation
 * @method BasketCookieQuery innerJoinCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the Cookie relation
 *
 * @method BasketCookieQuery leftJoinBasket($relationAlias = null) Adds a LEFT JOIN clause to the query using the Basket relation
 * @method BasketCookieQuery rightJoinBasket($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Basket relation
 * @method BasketCookieQuery innerJoinBasket($relationAlias = null) Adds a INNER JOIN clause to the query using the Basket relation
 *
 * @method BasketCookie findOne(PropelPDO $con = null) Return the first BasketCookie matching the query
 * @method BasketCookie findOneOrCreate(PropelPDO $con = null) Return the first BasketCookie matching the query, or a new BasketCookie object populated from the query conditions when no match is found
 *
 * @method BasketCookie findOneByBasketId(int $basket_id) Return the first BasketCookie filtered by the basket_id column
 * @method BasketCookie findOneByCookieId(int $cookie_id) Return the first BasketCookie filtered by the cookie_id column
 * @method BasketCookie findOneByQuantity(int $quantity) Return the first BasketCookie filtered by the quantity column
 * @method BasketCookie findOneBySortOrder(int $sort_order) Return the first BasketCookie filtered by the sort_order column
 *
 * @method array findById(int $id) Return BasketCookie objects filtered by the id column
 * @method array findByBasketId(int $basket_id) Return BasketCookie objects filtered by the basket_id column
 * @method array findByCookieId(int $cookie_id) Return BasketCookie objects filtered by the cookie_id column
 * @method array findByQuantity(int $quantity) Return BasketCookie objects filtered by the quantity column
 * @method array findBySortOrder(int $sort_order) Return BasketCookie objects filtered by the sort_order column
 *
 * @package    propel.generator./application/models/.om
 */
abstract class BaseBasketCookieQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBasketCookieQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'ci';
        }
        if (null === $modelName) {
            $modelName = 'CookieShop\\Model\\BasketCookie';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BasketCookieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BasketCookieQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BasketCookieQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BasketCookieQuery) {
            return $criteria;
        }
        $query = new BasketCookieQuery(null, null, $modelAlias);

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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   BasketCookie|BasketCookie[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BasketCookiePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BasketCookiePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 BasketCookie A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 BasketCookie A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `basket_id`, `cookie_id`, `quantity`, `sort_order` FROM `basket_cookie` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new BasketCookie();
            $obj->hydrate($row);
            BasketCookiePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return BasketCookie|BasketCookie[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|BasketCookie[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BasketCookiePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BasketCookiePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BasketCookiePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BasketCookiePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookiePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the basket_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBasketId(1234); // WHERE basket_id = 1234
     * $query->filterByBasketId(array(12, 34)); // WHERE basket_id IN (12, 34)
     * $query->filterByBasketId(array('min' => 12)); // WHERE basket_id >= 12
     * $query->filterByBasketId(array('max' => 12)); // WHERE basket_id <= 12
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
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterByBasketId($basketId = null, $comparison = null)
    {
        if (is_array($basketId)) {
            $useMinMax = false;
            if (isset($basketId['min'])) {
                $this->addUsingAlias(BasketCookiePeer::BASKET_ID, $basketId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basketId['max'])) {
                $this->addUsingAlias(BasketCookiePeer::BASKET_ID, $basketId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookiePeer::BASKET_ID, $basketId, $comparison);
    }

    /**
     * Filter the query on the cookie_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCookieId(1234); // WHERE cookie_id = 1234
     * $query->filterByCookieId(array(12, 34)); // WHERE cookie_id IN (12, 34)
     * $query->filterByCookieId(array('min' => 12)); // WHERE cookie_id >= 12
     * $query->filterByCookieId(array('max' => 12)); // WHERE cookie_id <= 12
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
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterByCookieId($cookieId = null, $comparison = null)
    {
        if (is_array($cookieId)) {
            $useMinMax = false;
            if (isset($cookieId['min'])) {
                $this->addUsingAlias(BasketCookiePeer::COOKIE_ID, $cookieId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cookieId['max'])) {
                $this->addUsingAlias(BasketCookiePeer::COOKIE_ID, $cookieId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookiePeer::COOKIE_ID, $cookieId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity >= 12
     * $query->filterByQuantity(array('max' => 12)); // WHERE quantity <= 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(BasketCookiePeer::QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(BasketCookiePeer::QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookiePeer::QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the sort_order column
     *
     * Example usage:
     * <code>
     * $query->filterBySortOrder(1234); // WHERE sort_order = 1234
     * $query->filterBySortOrder(array(12, 34)); // WHERE sort_order IN (12, 34)
     * $query->filterBySortOrder(array('min' => 12)); // WHERE sort_order >= 12
     * $query->filterBySortOrder(array('max' => 12)); // WHERE sort_order <= 12
     * </code>
     *
     * @param     mixed $sortOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function filterBySortOrder($sortOrder = null, $comparison = null)
    {
        if (is_array($sortOrder)) {
            $useMinMax = false;
            if (isset($sortOrder['min'])) {
                $this->addUsingAlias(BasketCookiePeer::SORT_ORDER, $sortOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortOrder['max'])) {
                $this->addUsingAlias(BasketCookiePeer::SORT_ORDER, $sortOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BasketCookiePeer::SORT_ORDER, $sortOrder, $comparison);
    }

    /**
     * Filter the query by a related Cookie object
     *
     * @param   Cookie|PropelObjectCollection $cookie The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BasketCookieQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCookie($cookie, $comparison = null)
    {
        if ($cookie instanceof Cookie) {
            return $this
                ->addUsingAlias(BasketCookiePeer::COOKIE_ID, $cookie->getId(), $comparison);
        } elseif ($cookie instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BasketCookiePeer::COOKIE_ID, $cookie->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCookie() only accepts arguments of type Cookie or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cookie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BasketCookieQuery The current query, for fluid interface
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
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CookieShop\Model\CookieQuery A secondary query class using the current class as primary query
     */
    public function useCookieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCookie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cookie', '\CookieShop\Model\CookieQuery');
    }

    /**
     * Filter the query by a related Basket object
     *
     * @param   Basket|PropelObjectCollection $basket The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BasketCookieQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBasket($basket, $comparison = null)
    {
        if ($basket instanceof Basket) {
            return $this
                ->addUsingAlias(BasketCookiePeer::BASKET_ID, $basket->getId(), $comparison);
        } elseif ($basket instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BasketCookiePeer::BASKET_ID, $basket->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBasket() only accepts arguments of type Basket or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Basket relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BasketCookieQuery The current query, for fluid interface
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
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CookieShop\Model\BasketQuery A secondary query class using the current class as primary query
     */
    public function useBasketQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBasket($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Basket', '\CookieShop\Model\BasketQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   BasketCookie $basketCookie Object to remove from the list of results
     *
     * @return BasketCookieQuery The current query, for fluid interface
     */
    public function prune($basketCookie = null)
    {
        if ($basketCookie) {
            $this->addUsingAlias(BasketCookiePeer::ID, $basketCookie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
