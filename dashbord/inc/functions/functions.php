<?php

function title(){ //To Get Dinamec Titel Page
    global $title;

    if(isset($title)){
        echo $title;
    }else{
        echo 'Defaul Page';
    }
}

function getData($select, $from, $where, $value,$fetch = 'fetchAll'){
     /**
     * this Function To Get All Data from database 
     **/
    global $con;
    global $count;
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $where = ?");
    $stmt->execute(array($value));
    $row = $stmt->$fetch();
    $count = $stmt->rowCount();
    return $row;
}

?>