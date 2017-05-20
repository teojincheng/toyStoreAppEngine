<?php

/**
 * This class represents one datastore.
 * Contains records of toys
 */

namespace GDS\lib;

use GDS\Schema;
use GDS\Store;

class Repository {

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
     * Retrieve recently added toys
     * 
     * @return type an array of toy enttites that are recently added
     */
    public function getRecentToys() {
        /*
          $arr_posts = $this->getCache()->get('recent');
          if(is_array($arr_posts)) {
          return $arr_posts;
          } else {
          return $this->updateCache();
          }
         */
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(POST_LIMIT);
        return $arr_posts;
    }

    /**
     * Retrieve all the toys in the datastore
     * 
     * @return type an array of toy entities
     */
    public function getAllToys() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->fetchAll();
        return $arr_posts;
    }

    /**
     * Update the cache from Datastore
     *
     */
    private function updateCache() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM toyStore")->fetchPage(POST_LIMIT);
        $this->getCache()->set('recent', $arr_posts);
        return $arr_posts;
    }

    /**
     * Inserts any entry of a toy into the datastore
     * 
     * @param type $str_name name of the toy
     * @param type $str_desc description of the toy
     * @param type $flt_price price of the toy
     * @param type $str_info information about the toy
     * @param type $int_rating average rating of the toy
     * @param type $str_path path to google cloud bucket which holds image of the toy
     */
    public function createToy($str_name, $str_desc, $flt_price, $str_info, $str_path) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'name' => $str_name,
                    'txtDescript' => $str_desc,
                    'price' => $flt_price,
                    'information' => $str_info,
                    'posted' => date('Y-m-d H:i:s'),
                    'imgpath' => $str_path
        ]));

        // Update the cache
        $this->updateCache();
    }

    /**
     * Update an entry of a toy. 
     * 
     * @param type $postToUpdate one entity object that represents a toy
     */
    public function updateToy($toyToUpdate) {
        $obj_store = $this->getStore();
        $obj_store->upsert($toyToUpdate);
    }

   /**
    * get one toy entity based on cloud datastore id
    * 
    * @param type $qId cloud datastore id of toy
    * @return type an array of which contains information of the toy
    */
    public function getToyByEntityId($qId) {
        $obj_store = $this->getStore();
        $obj_post = $obj_store->fetchById($qId);
        return $obj_post;
    }

    /**
     * Delete an entry of a toy
     * 
     * @param type $postToDelete one toy entity object
     */
    public function deleteToy($postToDelete) {
        $obj_store = $this->getStore();
        $obj_store->delete($postToDelete);
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
     * Schema for toy entries
     */
    private function makeSchema() {
        return (new Schema('toyStore'))
                        ->addString('name', FALSE)
                        ->addString('txtDescript', FALSE)
                        ->addFloat('price', FALSE)
                        ->addString('information', FALSE)
                        ->addInteger('rating', FALSE)
                        ->addDatetime('posted')
                        ->addString('imgpath', FALSE)
        ;
    }

}
