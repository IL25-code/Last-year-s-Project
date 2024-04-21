<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="project_page.css">
    <title>Project Page</title>
</head>

<body>
    <div class="button_container">
        <div class="files">
            <h2>Project</h2>
            <div class="buttons">
                <form action="" method="post">
                    <input type="submit" value="Create" name="f_create">
                    <input type="submit" value="Open" name="f_open">
                    <input type="submit" value="Save as" name="f_save_as">
                    <input type="submit" value="Close" name="f_close">
                </form>
            </div>
        </div>
        <div class="tasks">
            <h2>Tasks</h2>
            <div class="buttons">
                <form action="" method="post">
                    <input type="submit" value="Add" name="t_add">
                    <input type="submit" value="Remove" name="t_remove">
                    <input type="submit" value="Link" name="t_link">
                    <input type="submit" value="Unlink" name="t_unlink">
                    <input type="submit" value="Find" name="t_find">
                </form>
            </div>
        </div>
        <div class="resources">
            <h2>Resources</h2>
            <div class="buttons">
                <form action="" method="post">
                    <input type="submit" value="Add" name="r_add">
                    <input type="submit" value="Delete" name="r_delete">
                    <input type="submit" value="Link" name="r_link">
                    <input type="submit" value="Unlink" name="r_unlink">
                    <input type="submit" value="Find" name="r_find">
                </form>
            </div>
        </div>
    </div>
    <div class="second_part_container">
        <div class="table_container">
            <table class="tasks_table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>TimeFrame</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Link</th>
                    <th>Percentage</th>
                </tr>
                <?php
                require "database_connection.php";
                $CONNECTION = new Connection();
                $conn = $CONNECTION->connect();
                // $data = $CONNECTION->select_queries($conn,"SELECT t.id, t.name, t.timeframe, t.start_date, t.end_date, t.link FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id=".$_SESSION['project_id'])
                $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, FLOOR(t.timeframe / 86400000), t.start_date, t.end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='1'");
                $CONNECTION->table_rows($data);
                ?>
            </table>
        </div>
        <div class="gantt_container" id="chart_div">
            <div class="chart_div" id="chart_div"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['gantt']
                });
                google.charts.setOnLoadCallback(drawChart);

                function convertDateFormat(inputDate) {
                    var parts = inputDate.split('-');
                    return parts[0] + ', ' + parts[1] + ', ' + parts[2];
                }

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Task ID');
                    data.addColumn('string', 'Task Name');
                    // data.addColumn('string', 'Resource');
                    data.addColumn('date', 'Start Date');
                    data.addColumn('date', 'End Date');
                    data.addColumn('number', 'Duration');
                    data.addColumn('number', 'Percent Complete');
                    data.addColumn('string', 'Dependencies');

                    data.addRows([
                        <?php
                        function add_commas($value){
                            return "'".$value."'";
                        }
                        $conn = $CONNECTION->connect();
                        $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, t.timeframe, DATE_FORMAT(t.start_date, '%Y, %m, %d') start_date, DATE_FORMAT(t.end_date, '%Y, %m, %d') end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='1'");
                        foreach ($data as $value) {
                            echo "['" . $value['id'] . "', '" . $value['name'] . "', new Date(" . $value['start_date'] . "), new Date(" . $value['end_date'] . "), " . $value['timeframe'] . ", " . $value['percentage'] . ", " . (($value['link'] != '') ? add_commas($value['link']) : 'null') . "],";
                        }
                        ?>
                    ]);

                    var options = {
                        height: 500,
                            
                    };

                    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
            </script>

        </div>
    </div>

</body>

</html>