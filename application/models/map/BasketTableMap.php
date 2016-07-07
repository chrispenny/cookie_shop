<?php

namespace CookieShop\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'basket' table.
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
class BasketTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '/application/models/.map.BasketTableMap';

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
        $this->setName('basket');
        $this->setPhpName('Basket');
        $this->setClassname('CookieShop\\Model\\Basket');
        $this->setPackage('/application/models/');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 250, null);
        $this->addColumn('price', 'Price', 'FLOAT', true, null, null);
        $this->addColumn('size', 'Size', 'INTEGER', true, null, null);
        $this->addColumn('sort_order', 'SortOrder', 'INTEGER', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('BasketCookie', 'CookieShop\\Model\\BasketCookie', RelationMap::ONE_TO_MANY, array('id' => 'basket_id', ), null, null, 'BasketCookies');
    } // buildRelations()

} // BasketTableMap
