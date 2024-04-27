<?php
session_start();
$_SESSION["project_id"]=1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="project_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Project Page</title>
</head>

<body>
    <div class="button_container">
        <div class="files">
            <h2>Project</h2>
            <div class="buttons">
                <button id="login">Login</button>
                <button type="submit" name="f_create" id="f_create">Create</button>
                <button type="submit" name="f_open" id="f_open">Open</button>
                <button type="submit" name="f_save_as" id="f_save_as">Save as</button>
                <button type="submit" name="f_close" id="f_close">Close</button>
            </div>
        </div>
        <div class="tasks">
            <h2>Tasks</h2>
            <div class="buttons">
                <button type="submit" name="t_add" id="t_add">Add</button>
                <button type="submit" name="t_remove" id="t_remove">Remove</button>
                <button type="submit" name="t_link" id="t_link">Link</button>
                <button type="submit" name="t_unlink" id="t_unlink">Unlink</button>
                <button type="submit" name="t_find" id="t_find">Find</button>
            </div>
        </div>
        <div class="resources">
            <h2>Resources</h2>
            <div class="buttons">
                <button type="submit" name="r_add" id="r_add">Add</button>
                <button type="submit" name="r_delete" id="r_delete">Delete</button>
                <button type="submit" name="r_link" id="r_link">Link</button>
                <button type="submit" name="r_unlink" id="r_unlink">Unlink</button>
                <button type="submit" name="r_find" id="r_find">Find</button>
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
                $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, FLOOR(t.timeframe / 86400000), t.start_date, t.end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='".$_SESSION["project_id"]."'");
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
                        function add_commas($value)
                        {
                            return "'" . $value . "'";
                        }
                        $conn = $CONNECTION->connect();
                        $data = $CONNECTION->select_queries($conn, "SELECT t.id, t.name, t.timeframe, DATE_FORMAT(t.start_date, '%Y, %m, %d') start_date, DATE_FORMAT(t.end_date, '%Y, %m, %d') end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='".$_SESSION["project_id"]."'");
                        foreach ($data as $value) {
                            echo "['" . $value['id'] . "', '" . $value['name'] . "', new Date(" . $value['start_date'] . "), new Date(" . $value['end_date'] . "), " . $value['timeframe'] . ", " . $value['percentage'] . ", " . (($value['link'] != '') ? add_commas($value['link']) : 'null') . "],";
                        }
                        ?>
                    ]);

                    var options = {
                        backgroundColor: {
                            fill: '#F0FAFB',
                        },
                        width: '5000',
                        height: '5000',
                    };

                    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
            </script>
        </div>
    </div>
    <div class="popups">
        <button class="close_button">&times;</button>
        <div class="popup_window" taskadd>
            <h2>Insert Task</h2>
            <form action="" method="post">
                <input type="text" name="task_id" class="text_input" placeholder="Task ID (Optional)"><br>
                <input type="text" name="task_name" id="Tex" class="text_input" placeholder="Name" required=""><br>
                <input type="text" name="task_timeframe" id="Tex" class="text_input" placeholder="Timeframe"><br>
                <input type="text" name="task_start-date" class="text_input" placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
                <input type="text" name="task_end-date" class="text_input" placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
                <input type="text" name="Link" id="Tex" class="text_input" placeholder="Link"><br>
                <input type="text" name="Percentage" id="Tex" class="text_input" placeholder="Percentage"><br>
                <input type="submit" name="insert_item" value="Insert">
            </form>
        </div>
        <div class="popup_window" linktasks>
            <h2>Link Tasks</h2>
            <form action="" method="post">
                <select name="task1" id="task1" class="select">
                    <option value="" disabled selected>Choose task 1</option>
                    <?php
                        $data = $CONNECTION->select_queries($conn, "SELECT t.id FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='".$_SESSION["project_id"]."'");
                        foreach($data as $value){
                            echo "<option value='".$value["id"]."'>Task ID: ".$value["id"]."</option>";
                        }
                    ?>
                </select><br>
                <select name="task2" id="task2" class="select">
                    <option value="" disabled selected>Choose task 2</option>
                    <?php
                        $data = $CONNECTION->select_queries($conn, "SELECT t.id FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='".$_SESSION["project_id"]."'");
                        foreach($data as $value){
                            echo "<option value='".$value["id"]."'>Task ID: ".$value["id"]."</option>";
                        }
                    ?>
                </select>
                <input type="submit" name="insert_item" value="Link">
            </form>
        </div>
    </div>
    <script src="popups.js"></script>
</body>

</html>