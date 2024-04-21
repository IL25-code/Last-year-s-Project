<?php
$conn = $CONNECTION->connect($CREDENTIALS->hostname, $CREDENTIALS->username, $CREDENTIALS->password, $CREDENTIALS->database);
$data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, t.timeframe, t.start_date, t.end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='1'");
foreach ($data as $row) {
    echo "['" . $row["id"] . "', '" . $row["name"] . "',new Date(" . $row["start_date"] . "), new Date(" . $row["end_date"] . "), daysToMilliseconds(3),  " . $row["percentage"] . ",  '" . $row["link"] . "'],";
}
?>`