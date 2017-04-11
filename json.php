<?php
    if(isset($_GET['event_type'])) $event_type = $_GET['event_type'];
        
    $sql = 'SELECT * FROM ugrp_events';
    if ($event_type == "schedule"   ) $sql .= " WHERE event_type = 'schedule'";
    if ($event_type == "poster"     ) $sql .= " WHERE event_type = 'poster'";
    if ($event_type == "paper"      ) $sql .= " WHERE event_type = 'paper'";
    if ($event_type == "performance") $sql .= " WHERE event_type = 'performance'";

    include '../database.php';
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = $pdo->prepare($sql);
    $q->execute();
    $arr = $q->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    
    echo json_encode($arr);
?>