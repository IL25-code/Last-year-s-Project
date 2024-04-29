<?php
$start_date="2024-05-24";
$timeframe = 259200000;
echo $start_date."+".($timeframe/86400000);
echo "<br>";
echo date('Y-m-d',strtotime($start_date."+".($timeframe/86400000) ."days"));
?>