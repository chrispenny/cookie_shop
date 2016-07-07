<?php

namespace CookieShop\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'basket_cookie' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator./application/models/.map
 */
class BasketCookieTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '/application/models/.map.BasketCookieTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('basket_cookie');
        $this->setPhpName('BasketCookie');
        $this->setClassname('CookieShop\\Model\\BasketCookie');
        $this->setPackage('/application/models/');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('basket_id', 'BasketId', 'INTEGER', 'basket', 'id', true, null, null);
        $this->addForeignKey('cookie_id', 'CookieId', 'INTEGER', 'cookie', 'id', true, null, null);
        $this->addColumn('quantity', 'Quantity', 'INTEGER', true, null, null);
        $this->addColumn('sort_order', 'SortOrder', 'INTEGER', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cookie', 'CookieShop\\Model\\Cookie', RelationMap::MANY_TO_ONE, array('cookie_id' => 'id', ), null, null);
        $this->addRelation('Basket', 'CookieShop\\Model\\Basket', RelationMap::MANY_TO_ONE, array('basket_id' => 'id', ), null, null);
    } // buildRelations()

} // BasketCookieTableMap
