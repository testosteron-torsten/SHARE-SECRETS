<?php
    require "config.php";

    try 
    {
        $pdo = new PDO($DSN, $DB_USER, $DB_PASS);
    } 
    catch (Exception $e) 
    {
        die ("Problem connecting to database $DB_NAME as $DB_USER: " . $e->getMessage() );
    }
?>