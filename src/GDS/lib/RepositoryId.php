<?php

/**
 * Author: Teo Jin Cheng 
 * 
 * Usage of Library/Framework:
 * https://github.com/tomwalder/php-gds
 * 
 * This class represents one datastore.
 * Contains record of the ID for each datastore
 */

namespace GDS\lib;

use GDS\Schema;
use GDS\Store;

class RepositoryId {

    /**
     * Memcache instance
     *
     * @var \Memcached|null
     */
    private $obj_cache = NULL;

    /**
     * GDS Store instance
     *
     * @var Store|null
     */
    private $obj_store = NULL;

    /**
     * @return \Memcached|null
     */
    private function getCache() {

        if (NULL === $this->obj_cache) {
            $this->obj_cache = new \Memcached();
        }
        return $this->obj_cache;
    }

    /**
     * Update the cache from Datastore
     *
     */
    private function updateCache() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM ids")->fetchPage(POST_LIMIT);
        $this->getCache()->set('recent', $arr_posts);
        return $arr_posts;
    }

    /**
     * Insert an entry into the datastore
     * 
     * @param type $int_toyid id of the toy
     * @param type $int_cartid id of one cart item
     * @param type $int_reviewid id of one review
     * @param type $int_userid id of one user
     */
    public function createEntry($int_toyid, $int_cartid, $int_reviewid, $int_userid) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'toyid' => $int_toyid,
                    'cartid' => $int_cartid,
                    'reviewid' => $int_reviewid,
                    'userid' => $int_userid
        ]));

        // Update the cache
        $this->updateCache();
    }
    
    /**
     * 
     * @return type
     */

    public function retrieveId() {
        $obj_store = $this->getStore();
        return $obj_store->fetchOne();
    }

    /**
     * 
     * @param type $entityToUpdate
     */
    public function updateEntry($entityToUpdate) {
        $obj_store = $this->getStore();
        $obj_store->upsert($entityToUpdate);
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
     * Schema for entries
     */
    private function makeSchema() {
        return (new Schema('ids'))
                        ->addInteger('toyid')
                        ->addInteger('cartid')
                        ->addInteger('reviewid')
                        ->addInteger('userid')

        ;
    }

}
