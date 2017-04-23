<?php
    header('Access-Control-Allow-Origin: *'); 
    
    if(isset($_GET['event_type'])) $event_type = $_GET['event_type'];
    
    $sql = 'SELECT * FROM ugrp_events';
    if(isset($_GET['search'])) {
        $param = $_GET['search'];
        if ($event_type == "schedule") $sql .= " WHERE " .
            "event_type = 'schedule' AND location LIKE '%" . $param . "%' OR " .
            "event_type = 'schedule' AND title LIKE '%" . $param . "%' OR " .
            "event_type = 'schedule' AND description LIKE '%" . $param . "%' OR " .
            "event_type = 'schedule' AND presenters LIKE '%" . $param . "%'";
        if ($event_type == "poster") $sql .= " WHERE " .
            "event_type = 'poster' AND location LIKE '%" . $param . "%' OR " .
            "event_type = 'poster' AND title LIKE '%" . $param . "%' OR " .
            "event_type = 'poster' AND description LIKE '%" . $param . "%' OR " .
            "event_type = 'poster' AND presenters LIKE '%" . $param . "%'";
        if ($event_type == "paper") $sql .= " WHERE " .
            "event_type = 'paper' AND location LIKE '%" . $param . "%' OR " .
            "event_type = 'paper' AND title LIKE '%" . $param . "%' OR " .
            "event_type = 'paper' AND description LIKE '%" . $param . "%' OR " .
            "event_type = 'paper' AND presenters LIKE '%" . $param . "%'";
        if ($event_type == "performance") $sql .= " WHERE " .
            "event_type = 'performance' AND location LIKE '%" . $param . "%' OR " .
            "event_type = 'performance' AND title LIKE '%" . $param . "%' OR " .
            "event_type = 'performance' AND description LIKE '%" . $param . "%' OR " .
            "event_type = 'performance' AND presenters LIKE '%" . $param . "%'";
    } else {
        if ($event_type == "schedule"   ) $sql .= " WHERE event_type = 'schedule'";
        if ($event_type == "poster"     ) $sql .= " WHERE event_type = 'poster'";
        if ($event_type == "paper"      ) $sql .= " WHERE event_type = 'paper'";
        if ($event_type == "performance") $sql .= " WHERE event_type = 'performance'";
    }
    
    include 'database.php';
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = $pdo->prepare($sql);
    $q->execute();
    $arr = $q->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    
    // Compare arrays based on title key.
    function cmp($a, $b) {
        $numA = explode(".",$a['title']);
        $numB = explode(".",$b['title']);
        if ($numA[0] == $numB[0]) return 0;
        return ($numA[0] < $numB[0]) ? -1 : 1;
    }
    
    // Sort Array if Poster
    if ($event_type == "poster") {
        usort($arr, 'cmp');
    }
    
    echo json_encode($arr);
?>