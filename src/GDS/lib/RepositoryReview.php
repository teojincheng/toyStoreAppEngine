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
    * Inserts an entry of a review into the datastore
    * 
    * @param type $int_toyid cloud datastore id of toy
    * @param type $str_username name of user who wrote the review
    * @param type $str_review the actual review text
    * @param type $int_rating the rating for the toy given by the user
    */
    public function createReview($int_toyid, $str_username, $str_review, $int_rating) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
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
                        ->addInteger('toyId', FALSE)
                        ->addString('username', FALSE)
                        ->addString('reviewText', FALSE)
                        ->addInteger('rating', FALSE)
        ;
    }

}
