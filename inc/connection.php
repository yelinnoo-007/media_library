<?php
    try {
        $db =new PDO('sqlite:' .__DIR__. '/database.db');
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Unable to connect.";
        //echo $e->getMessage();
        exit;
    }
    
    // try {
    //     $result = $db->query("select media_id,title,category,img from Media");
    // } catch (Exception $e) {
    //     echo $e->getMessage();
    //     echo "Unable to retrieved result";
    //     exit;
    // }
    // $catalog = $result->fetchAll();
?>