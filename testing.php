<?php
require "database_connection.php";
$CONNECTION = new Connection();
$conn = $CONNECTION->connect();
                        $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, t.timeframe, DATE_FORMAT(t.start_date, '%Y, %m, %d') start_date, DATE_FORMAT(t.end_date, '%Y, %m, %d') end_date, COALESCE(NULLIF(t.link, ''), '') link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='1'");
                        foreach ($data as $value) {
                            echo "['" . $value['id'] . "', '" . $value['name'] . "', new Date(" . $value['start_date'] . "), new Date(" . $value['end_date'] . "), " . $value['timeframe'] . ", " . $value['percentage'] . ", " . (($value['link'] != '') ? $value['link'] : 'null') . "],";
                        }
