<?php
    include "functions.php";
    $date = date('Y-m-d', strtotime('-30 days'));

    try 
    {
        $sth = $pdo->prepare("DELETE FROM passwords WHERE created <= ?");
        $sth->execute(array($date));
        echo"Everything okay.";
    } 
    catch (Exception $e) 
    {
        die ("Problem deleting secret from Database, contact your Administrator" . $e->getMessage() );
    }
?>