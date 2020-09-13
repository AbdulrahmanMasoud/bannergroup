<?php

    $dns = 'mysql:host=localhost;dbname=banergroup';
    $user = 'root';
    $pass = '';
    $options = array(
        //دي عشان اي حاجه تنظاف في الداتابيز بالعربي تبقا بالعربي عادي متبوظش
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con = new PDO($dns,$user,$pass,$options);//ده عشان يعمل اتصال بالداتابيز
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo 'connected';
    }
    catch (PDOException $e){//ده عشان لو فيه ايرور يرجعه
        echo 'Filed To Conect' . $e->getMessage();
    }


?>