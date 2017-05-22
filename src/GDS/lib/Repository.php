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
        $arr_posts = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(10);
        return $arr_posts;
    }
    
    
    public function getRecentToysTopThree() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(3,0);
        return $arr_posts;
    }
    
        public function getRecentToysNextThree() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(3,3);
        return $arr_posts;
    }
    
    /**
     * Execute an sql query against this datastore
     * 
     * @param type $sql the sql statement to execute
     * @return type an array of toy entity as result of sql statment. 
     */
    
    public function executeToysQuery($sql){
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query($sql)->fetchPage(100);
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
     * Inserts an entry of a toy into the datastore
     * 
     * @param type $int_id id of entry
     * @param type $str_name name of toy
     * @param type $str_desc description of toy
     * @param type $flt_price price of one toy
     * @param type $str_info information about the toy
     * @param type $str_path url to image of the toy
     */
    public function createToy($int_id,$str_name, $str_desc, $flt_price, $str_info, $str_path) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'id' => $int_id,
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
     * @param type $toyToUpdate one entity object that represents a toy
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
     * @param type $toyToDelete one toy entity object
     */
    public function deleteToy($toyToDelete) {
        $obj_store = $this->getStore();
        $obj_store->delete($toyToDelete);
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
                        ->addInteger("id",FALSE)
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
