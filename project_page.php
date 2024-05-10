<?php
require "database_connection.php";
require "task_window.php";
session_start();
$TASK_FUNCTIONS = new Task_Window();
$_SESSION["project_id"] = 1;
$_SESSION["db_connection"]= new Connection();
$conn = $_SESSION["db_connection"]->connect();

if(isset($_POST['insert_task'])){
    if($TASK_FUNCTIONS->add($conn,($_POST['task_id']==NULL)? "''":$_POST['task_id'],$_POST['task_name'],(int)$_POST['task_timeframe']*86400000,$_POST['task_start-date'],$_POST['task_end-date'],($_POST['task_link']==NULL)? 'NULL':$_POST['task_link'],($_POST['task_percentage']==NULL)? 0:$_POST['task_percentage'])){
        echo 'Error';
    }
}

if(isset($_POST['remove_task'])){
    if($TASK_FUNCTIONS->remove($conn,$_POST['toremoveTask'])){
        echo 'Error';
    }
}


if(isset($_POST['link_task'])){
    if($TASK_FUNCTIONS->link($conn,$_POST['toLink'],$_POST['toLink_To'])){
        echo 'Error';
    }
}
if(isset($_POST['unlink'])){
    if($TASK_FUNCTIONS->unlink($conn,$_POST['idToUnlink'])){
        echo 'Error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="project_page.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Project Page</title>
</head>

<body>
    <div class="button_container">
        <div class="function_containers">
            <h2>Project</h2>
            <div class="buttons">
                <button type="submit" name="f_create" id="f_create">Create</button>
                <button type="submit" name="f_open" id="f_open">Open</button>
                <button type="submit" name="f_save_as" id="f_save_as">Save as</button>
                <button type="submit" name="f_close" id="f_close">Close</button>
            </div>
        </div>
        <div class="function_containers">
            <h2>Tasks</h2>
            <div class="buttons">
                <button type="submit" name="t_add" id="t_add">Add</button>
                <button type="submit" name="t_remove" id="t_remove">Remove</button>
                <button type="submit" name="t_link" id="t_link">Link</button>
                <button type="submit" name="t_unlink" id="t_unlink">Unlink</button>
            </div>
        </div>
        <div class="function_containers">
            <h2>Resources</h2>
            <div class="buttons">
                <button type="submit" name="r_show_list" id="r_show_list">Show List</button>
                <button type="submit" name="r_request" id="r_request">Request</button>
                <button type="submit" name="r_link" id="r_link">Assign</button>
                <button type="submit" name="r_unlink" id="r_unlink">Unassign</button>
            </div>
        </div>
    </div>
    <div class="second_part_container">
        <div class="table_container">
            <table class="tasks_table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>TimeFrame (days)</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Link</th>
                    <th>Percentage</th>
                </tr>
                <?php
                $data = $_SESSION["db_connection"]->select_queries($conn, "SELECT t.id, t.name, FLOOR(t.timeframe / 86400000), t.start_date, t.end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='" . $_SESSION["project_id"] . "'");
                $_SESSION["db_connection"]->table_rows($data);
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
                        $data = $_SESSION["db_connection"]->select_queries($conn, "SELECT t.id, t.name, t.timeframe, DATE_FORMAT(t.start_date, '%Y, %m, %d') start_date, DATE_FORMAT(t.end_date, '%Y, %m, %d') end_date, t.link, t.percentage FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='" . $_SESSION["project_id"] . "'");
                        foreach ($data as $value) {
                            echo "['" . $value['id'] . "', '" . $value['name'] . "', new Date(" . $value['start_date'] . "), new Date(" . $value['end_date'] . "), " . $value['timeframe'] . ", " . $value['percentage'] . ", " . (($value['link'] != '') ? add_commas($value['link']) : 'null') . "],";
                        }
                        ?>
                    ]);

                    var options = {
                        backgroundColor: {
                            fill: '#F0FAFB',
                        },
                        hAxis:{
                            scale: 0.5,
                        },
                        vAxis:{
                            scale: 0.5,
                        },
                    };

                    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    chart.draw(data, options);
                }
            </script>
        </div>
    </div>
    <!-- Project Create -->
    <dialog id="projectcreate">
        <h2>Create Project</h2>
        <form action="" method="post">
            <input type="submit" name="create_project" value="Create">
        </form>

        <button class="close_button">&times;</button>
    </dialog>
    <!-- Project Save As -->
    <dialog id="projectsaveas">
        <h2>Save project as</h2>
        <form action="" method="post">
            <input type="text" name="proj_name" placeholder="Project Name">
            <input type="submit" name="saveas_project" value="Save">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Project Open -->
    <dialog id="projectopen">
        <h2>Create Project</h2>
        <form action="" method="post">
            <select name="task2" id="task2" class="select" required="">
                <option value="" disabled selected>Choose project</option>
                <?php
                // Select p.name from project-users pu join projects p on pu.project_id = p.id where pu.user_id = $_SESSION["user_id"];
                ?>

            </select>
            <input type="submit" name="create_project" value="Open">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Task Add -->
    <dialog id="taskadd">
        <h2>Insert Task</h2>
        <form action="" method="post">
            <input type="text" name="task_id" class="text_input" placeholder="Task ID (Optional)"><br>
            <input type="text" name="task_name"class="text_input" placeholder="Name" required=""><br>
            <input type="text" name="task_timeframe" class="text_input" placeholder="Timeframe(days)"><br>
            <input type="text" name="task_start-date" class="text_input" placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
            <input type="text" name="task_end-date" class="text_input" placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
            <input type="text" name="task_link" class="text_input" placeholder="Link"><br>
            <input type="text" name="task_percentage" class="text_input" placeholder="Percentage"><br>
            <input type="submit" name="insert_task" value="Insert">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Task Remove -->
    <dialog id="taskremove">
        <h2>Remove Task</h2>
        <form action="" method="post">
            <select name="toremoveTask" id="toremoveTask" class="select" required="">
                <option value="" disabled selected>Choose task 1</option>
                <?php
                $tasks_id_name = $_SESSION["db_connection"]->select_queries($conn, "SELECT t.id,t.name FROM tasks t JOIN projects p ON t.project=p.id WHERE p.id='" . $_SESSION["project_id"] . "'");
                foreach ($tasks_id_name as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select><br>
            <input type="submit" name="remove_task" value="Remove">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Task Link -->
    <dialog id="tasklink">
        <h2>Link Tasks</h2>
        <form action="" method="post">
            <select name="toLink" id="toLink" class="select" required="">
                <option value="" disabled selected>Choose task 1</option>
                <?php
                foreach ($tasks_id_name as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select><br>
            <select name="toLink_To" id="toLink_To" class="select" required="">
                <option value="" disabled selected>Choose task 2</option>
                <?php
                foreach ($tasks_id_name as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select>
            <input type="submit" name="link_task" value="Link">
        </form>

        <button class="close_button">&times;</button>
    </dialog>
    <!-- Task Unlink -->
    <dialog id="taskunlink">
        <h2>Unlink Tasks</h2>
        <form action="" method="post">
            <select name="idToUnlink" id="idToUnlink" class="select" required="">
                <option value="" disabled selected>Choose task 1</option>
                <?php
                foreach ($tasks_id_name as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select><br>
            
            <input type="submit" name="unlink_task" value="Unlink">
        </form>

        <button class="close_button">&times;</button>
    </dialog>
    <!-- Resource Show List -->
    <dialog id="resourceshow">
        <h2>Resource List</h2>
        <div class="resource_list">
            <?php
                // Select * from resources where project=$_SESSION["project_id"]
            ?>
        </div>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Resource Request -->
    <dialog id="resourcerequest">
        <h2>Request Resources</h2>
        <form action="" method="post">

            <input type="submit" name="request_resource" value="Save">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Resource Assign -->
    <dialog id="resourceassign">
        <h2>Assign Resources</h2>
        <form action="" method="post">
            <select name="task_for_resource_assign" id="task_for_resource_assign" class="select" required="">
                <option value="" disabled selected>Choose task</option>
                <?php
                foreach ($tasks_id_name as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select><br>
            <select name="resourceToAssign" id="resourceToAssign" class="select" required="">
                <option value="" disabled selected>Choose resource</option>
                <?php
                foreach ($_SESSION["db_connection"]->select_queries($conn, "SELECT r.id,r.name FROM resources r JOIN projects p ON r.project=p.id WHERE p.id='" . $_SESSION["project_id"] . "'") as $value) {
                    echo "<option value='" . $value["id"] . "'>Name: " . $value["name"] . " (ID:" . $value["id"] . ")</option>";
                }
                ?>
            </select><br>
            <input type="submit" name="assign_resource" value="Unlink">
        </form>
        <button class="close_button">&times;</button>
    </dialog>
    <!-- Resource Unassign -->
    <script type="text/javascript" src="popups.js"></script>

</body>

</html>