<?php

/**
 * This class represents one datastore.
 * Contains records of shopping carts. 
 */

namespace GDS\lib;

use GDS\Schema;
use GDS\Store;

class RepositoryCart {

   
   

    /**
     * GDS Store instance
     *
     * @var Store|null
     */
    private $obj_store = NULL;

  

    /**
     * Retrive all the cart items of one user.
     * 
     * @param type $userId  the cloud datastore id of one user
     * @return type an array of cart entry entities
     */
    public function getCartItemsOfUser($userId) {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM carts WHERE userid = '".$userId."'");
        return $arr_posts;
    }

    

   /**
    * Insert one entry of item into the shopping cart
    * 
    * @param type $int_toyid cloud datastore id of the toy
    * @param type $int_userid cloud datastore id of the user
    * @param type $int_qty amount of toy the user add into cart
    * @param type $flt_unitPrice the price of one toy that is being added into cart
    */
    public function createCartItem($int_toyid, $int_userid, $int_qty, $flt_unitPrice) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'toyId' => $int_toyid,
                    'userid' => $int_userid,
                    'qty' => $int_qty,
                    'unitPrice' => $flt_unitPrice
        ]));

       
    }

    /**
     * Determine and return a Store
     */
    private function getStore() {
        if (NULL === $this->obj_store) {
            $this->obj_store = new Store($this->makeSchema());
        }
        return $this->obj_store;
    }

    /**
     * Schema for cart  entries
     */
    private function makeSchema() {
        return (new Schema('carts'))
                        ->addInteger('toyId', FALSE)
                        ->addInteger('userid', FALSE)
                        ->addInteger('qty', FALSE)
                        ->addFloat('unitPrice', FALSE)
        ;
    }

}
