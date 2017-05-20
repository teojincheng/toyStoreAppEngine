<?php

/**
 * Delete one entry of a toy.
 */
require_once('../vendor/autoload.php');
require_once('../config.php');

use \GDS\lib\Repository;

$obj_repo = new Repository();

$arrayOfEntity = array();

$numToLoop = count($_POST["postsToDelete"]);

for ($i = 0; $i < $numToLoop; $i++) {

    $tmp_entity = $obj_repo->getToyByEntityId($_POST["postsToDelete"][$i]);


    array_push($arrayOfEntity, $tmp_entity);
}

for ($j = 0; $j < $numToLoop; $j++) {
    $obj_repo->deleteToy($arrayOfEntity[$j]);
}
?>