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
use CookieShop\Model\BasketCookie;
use CookieShop\Model\Cookie;
use CookieShop\Model\CookiePeer;
use CookieShop\Model\CookieQuery;

/**
 * Base class that represents a query for the 'cookie' table.
 *
 *
 *
 * @method CookieQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CookieQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CookieQuery orderByImg($order = Criteria::ASC) Order by the img column
 *
 * @method CookieQuery groupById() Group by the id column
 * @method CookieQuery groupByName() Group by the name column
 * @method CookieQuery groupByImg() Group by the img column
 *
 * @method CookieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CookieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CookieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CookieQuery leftJoinBasketCookie($relationAlias = null) Adds a LEFT JOIN clause to the query using the BasketCookie relation
 * @method CookieQuery rightJoinBasketCookie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BasketCookie relation
 * @method CookieQuery innerJoinBasketCookie($relationAlias = null) Adds a INNER JOIN clause to the query using the BasketCookie relation
 *
 * @method Cookie findOne(PropelPDO $con = null) Return the first Cookie matching the query
 * @method Cookie findOneOrCreate(PropelPDO $con = null) Return the first Cookie matching the query, or a new Cookie object populated from the query conditions when no match is found
 *
 * @method Cookie findOneByName(string $name) Return the first Cookie filtered by the name column
 * @method Cookie findOneByImg(string $img) Return the first Cookie filtered by the img column
 *
 * @method array findById(int $id) Return Cookie objects filtered by the id column
 * @method array findByName(string $name) Return Cookie objects filtered by the name column
 * @method array findByImg(string $img) Return Cookie objects filtered by the img column
 *
 * @package    propel.generator./application/models/.om
 */
abstract class BaseCookieQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCookieQuery object.
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
            $modelName = 'CookieShop\\Model\\Cookie';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CookieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CookieQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CookieQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CookieQuery) {
            return $criteria;
        }
        $query = new CookieQuery(null, null, $modelAlias);

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
     * @return   Cookie|Cookie[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CookiePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CookiePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Cookie A model object, or null if the key is not found
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
     * @return                 Cookie A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `img` FROM `cookie` WHERE `id` = :p0';
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
            $obj = new Cookie();
            $obj->hydrate($row);
            CookiePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Cookie|Cookie[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Cookie[]|mixed the list of results, formatted by the current formatter
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
     * @return CookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CookiePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CookieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CookiePeer::ID, $keys, Criteria::IN);
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
     * @return CookieQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CookiePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CookiePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CookiePeer::ID, $id, $comparison);
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
     * @return CookieQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CookiePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the img column
     *
     * Example usage:
     * <code>
     * $query->filterByImg('fooValue');   // WHERE img = 'fooValue'
     * $query->filterByImg('%fooValue%'); // WHERE img LIKE '%fooValue%'
     * </code>
     *
     * @param     string $img The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CookieQuery The current query, for fluid interface
     */
    public function filterByImg($img = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($img)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $img)) {
                $img = str_replace('*', '%', $img);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CookiePeer::IMG, $img, $comparison);
    }

    /**
     * Filter the query by a related BasketCookie object
     *
     * @param   BasketCookie|PropelObjectCollection $basketCookie  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CookieQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBasketCookie($basketCookie, $comparison = null)
    {
        if ($basketCookie instanceof BasketCookie) {
            return $this
                ->addUsingAlias(CookiePeer::ID, $basketCookie->getCookieId(), $comparison);
        } elseif ($basketCookie instanceof PropelObjectCollection) {
            return $this
                ->useBasketCookieQuery()
                ->filterByPrimaryKeys($basketCookie->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBasketCookie() only accepts arguments of type BasketCookie or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BasketCookie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CookieQuery The current query, for fluid interface
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
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CookieShop\Model\BasketCookieQuery A secondary query class using the current class as primary query
     */
    public function useBasketCookieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBasketCookie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BasketCookie', '\CookieShop\Model\BasketCookieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Cookie $cookie Object to remove from the list of results
     *
     * @return CookieQuery The current query, for fluid interface
     */
    public function prune($cookie = null)
    {
        if ($cookie) {
            $this->addUsingAlias(CookiePeer::ID, $cookie->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
