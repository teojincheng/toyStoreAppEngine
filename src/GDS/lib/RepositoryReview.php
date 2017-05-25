<?php

/**
 * This class represents one datastore.
 * Contains records of reviews of toys
 */

namespace GDS\lib;

use GDS\Schema;
use GDS\Store;

class RepositoryReview {

   
   

    /**
     * GDS Store instance
     *
     * @var Store|null
     */
    private $obj_store = NULL;

  

  /**
   * Retrieve all the reviews and rating of one toy
   * 
   * @param type $toyId  cloud datastore id of a toy
   * @return type an array of review entries
   */
    public function getReviewsOfAToy($toyId) {
        $obj_store = $this->getStore();
        $arr_posts = $obj_store->query("SELECT * FROM reviews WHERE toyId = '".$toyId."'");
        return $arr_posts;
    }

    

  /**
   * Inserts an entry of a reivew into datastore
   * 
   * @param type $int_id id of the entry
   * @param type $int_toyid id of the toy
   * @param type $str_username user's name who wrote the review
   * @param type $str_review actual review itself
   * @param type $int_rating rating of the toy
   */
    public function createReview($int_id,$int_toyid, $str_username, $str_review, $int_rating) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'id' => $int_id,
                    'toyId' => $int_toyid,
                    'username' => $str_username,
                    'reviewText' => $str_review,
                    'rating' => $int_rating
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
     * Schema for review entries
     */
    private function makeSchema() {
        return (new Schema('reviews'))
                        ->addInteger('id')
                        ->addInteger('toyId')
                        ->addString('username')
                        ->addString('reviewText')
                        ->addInteger('rating')
        ;
    }

}
