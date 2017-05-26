<?php

/**
 * Author: Teo Jin Cheng
 * 
 * Usage of Library/Framework:
 * https://github.com/tomwalder/php-gds
 * 
 * 
 * This class represents one datastore.
 * Contains records of users
 */

namespace GDS\lib;

use GDS\Schema;
use GDS\Store;

class RepositoryUser {

   

    /**
     * GDS Store instance
     *
     * @var Store|null
     */
    private $obj_store = NULL;
    
    
    
    
    /**
     * Retrieve all the columns of a record stored in the datastore of a user
     * 
     * @param type $inUsername username user supplied when user login
     * @return type an array which contain the data of user. 
     */
    public function getAllColsFromDatastore($inUsername){
        $obj_store = $this->getStore();
        $arr_user = $obj_store->fetchOne("SELECT * FROM users WHERE username = @inname",['inname'=>$inUsername]);
        return $arr_user;
        
    }

 

  /**
   * Inserts an entry of a user into the datastore. 
   * 
   * @param type $int_id id of one entry
   * @param type $str_name actual name of user
   * @param type $str_username username to login
   * @param type $str_password password to login
   * @param type $str_role role of the user
   * @param type $str_email email address of the user. 
   */
    public function createUser($int_id,$str_name, $str_username, $str_password, $str_role, $str_email) {
        $obj_store = $this->getStore();
        $obj_store->upsert($obj_store->createEntity([
                    'id' => $int_id,
                    'name' => $str_name,
                    'username' => $str_username,
                    'password' => $str_password,
                    'role' => $str_role,
                    'email' => $str_email
        ]));

       
    }

    /**
     * Update an entry of a user 
     * 
     * @param type $userToUpdate one entity object that represents a toy
     */
    public function updateUser($userToUpdate) {
        $obj_store = $this->getStore();
        $obj_store->upsert($userToUpdate);
    }

   /**
    * Get one user entity based on cloud datastore id
    * 
    * @param type $qId cloud datastore id of the user
    * @return type an array which contains information about the user
    */
    public function getUserByEntityId($qId) {
        $obj_store = $this->getStore();
        $obj_post = $obj_store->fetchById($qId);
        return $obj_post;
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
     * Schema for user entries
     */
    private function makeSchema() {
        return (new Schema('users'))
                        ->addInteger('id')
                        ->addString('name')
                        ->addString('username')
                        ->addString('password')
                        ->addString('role')
                        ->addString('email')
                        
        ;
    }

}
