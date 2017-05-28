<?php

/**
 * Author: Teo Jin Cheng
 * 
 * Usage of Library/Framework:
 * https://github.com/tomwalder/php-gds
 * 
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
        $arr_reviews = $obj_store->query("SELECT * FROM reviews WHERE toyId = $toyId")->fetchAll();
        return $arr_reviews;
    }

    
      /**
       * Inserts one review of a toy into the datastore
       * 
       * @param type $int_id id of the review
       * @param type $int_toyid id of the toy being reviewed
       * @param type $int_userid id of the user writing the review
       * @param type $str_username real name of user writing the review
       * @param type $str_review the actual review text
       * @param type $int_rating the rating of the toy accompanying the review. 
       */
 
    public function createReview($int_id,$int_toyid,$int_userid, $str_username, $str_review, $int_rating) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'id' => $int_id,
                    'toyId' => $int_toyid,
                    'userid' => $int_userid,
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
                        ->addInteger('userid')
                        ->addString('username')
                        ->addString('reviewText')
                        ->addInteger('rating')
        ;
    }

}
