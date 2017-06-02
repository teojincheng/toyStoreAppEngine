<?php

/**
 * Author: Teo Jin Cheng
 * 
 * Usage of Library/Framework:
 * https://github.com/tomwalder/php-gds
 * 
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
    
    private $review_repo = NULL;
  

    /**
     * @return \Memcached|null
     */
    private function getCache() {

        if (NULL === $this->obj_cache) {
            $this->obj_cache = new \Memcached();
        }
        return $this->obj_cache;
    }
    
    
    public function foo(){
        $review_repo = new RepositoryReview();
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
        $arr_toys = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(10);
        return $arr_toys;
    }
    
    /**
     * Retrieve from the datastore the lastest 3 toys that were added
     * 
     * @return type array containing information about the toys
     */
    public function getRecentToysTopThree() {
        $obj_store = $this->getStore();
        $arr_toys = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(3,0);
        return $arr_toys;
    }
    /**
     * Retrieve from the datastore the next 3 latest toy that were added
     * 
     * @return type array containing information about the toys
     */
        public function getRecentToysNextThree() {
        $obj_store = $this->getStore();
        $arr_toys = $obj_store->query("SELECT * FROM toyStore ORDER BY posted DESC")->fetchPage(3,3);
        return $arr_toys;
    }
    
   

    /**
     * Retrieve all the toys in the datastore
     * 
     * @return type an array of toy entities
     */
    public function getAllToys() {
        $obj_store = $this->getStore();
        $arr_toys = $obj_store->fetchAll();
        return $arr_toys;
    }

    /**
     * Update the cache from Datastore
     *
     */
    private function updateCache() {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM toyStore")->fetchPage(10);
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
        $obj_toy = $obj_store->fetchById($qId);
        return $obj_toy;
    }
    
    /**
     * get one toy entity based on id column in the datasore
     * 
     * @param type $qid the id of the toy in the datastore
     * @return type array which contains information of the toy
     */
    public function getToyByToyId($qid){
         $obj_store = $this->getStore();
         $arr_toy = $obj_store->fetchOne("SELECT * FROM toyStore WHERE id =$qid");
         return $arr_toy;
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
                        ->addInteger("id")
                        ->addString('name')
                        ->addString('txtDescript')
                        ->addFloat('price')
                        ->addString('information')
                        ->addInteger('rating')
                        ->addDatetime('posted')
                        ->addString('imgpath')
        ;
    }

}
