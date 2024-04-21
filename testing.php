<?php
$date="15-03-2013";
$date1=date_create($date);
$date2=date_create("2013-12-12");
$diff=date_diff($date1,$date2);
$timeframe=$diff->format("%a");
echo $diff->format("%a");
echo "<br>";
echo $date;
echo "<br>";
echo date('d-m-Y', strtotime($date . ' + ' . $timeframe . " days"));
echo "<br>";
echo(date('d-m-Y',strtotime($date."- 5 days")). "<br>");
?>