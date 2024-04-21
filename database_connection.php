<?php
class Connection{
    function connect($hostname, $user, $pass, $data)
    {
        $conn = new mysqli($hostname, $user, $pass, $data);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
            return false;
        }
        return $conn;
    }

    function select_queries($conn, $query)
    {
        $ris = $conn->query($query);
        if (!$ris) {
            return false;
        }
        $rows = [];
        while ($row = $ris->fetch_assoc()) {
            $rows[] = $row;
        }
        $ris->close();
        return $rows;
    }

    function searchFields($row)
    {
        foreach ($row as $key => $item) {
            $fields[] = $key;
        }
        return $fields;
    }

    function toString($row)
    {
        $string = "";
        foreach ($row as $value) {
            $string += $value + ", ";
        }
        return $string;
    }

    function printTable($table, $fields)
    {
        echo "<table>";
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<th>" . $field . "</th>";
        }
        echo "</tr>";
        foreach ($table as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    function table_rows($table){
        foreach ($table as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
    }

    function dml_query($conn, $query)
    {
        $ris = $conn->query($query);
        if (!$ris) {
            return false;
        }
        return $ris;
    }

    function disconnect($conn)
    {
        $conn->close();
    }
}
?>