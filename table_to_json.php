<?php
    require "database_connection";
    $CONNECTION = new Connection();
    $conn = $CONNECTION->connect();
    $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, t.start_date, t.end_date, FLOOR(t.timeframe / 86400000), t.percentage, t.link FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='1'");
    $json = json_encode($data);
    echo $json;
?>