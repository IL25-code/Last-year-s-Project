<?php
    // session_start();
    class Task_Window{
        function add($conn,$id, $name, $timeframe, $start_date, $end_date, $link=NULL,$percentage){
            (new Task_Window())->calc_dates($timeframe, $start_date, $end_date);
            $_SESSION["db_connection"]->dml_query($conn,"INSERT INTO tasks (id, name, timeframe, start_date, end_date, link, project, percentage) VALUES (".$id.", '".$name."', ".$timeframe.", '".$start_date."', '".$end_date."', ".$link.", ".$_SESSION['project_id'].", ".$percentage.")");
        }
        
        function calc_dates(&$timeframe, &$start_date, &$end_date){
            if($timeframe==NULL){
                if($start_date!=NULL && $end_date!=NULL){
                    $timeframe=floor((-strtotime($start_date) + strtotime($end_date)) * 1000); //Trasforma il risulato in secondi in millisecondi
                }
                else{
                    $timeframe=86400000;
                }
            }
            if($start_date==NULL){
                if($end_date!=NULL){
                    $start_date=date('Y-m-d',strtotime($end_date."-".($timeframe/86400000)."days"));
                }
                else{
                    $start_date=date('Y-m-d');
                }
            }
            if($end_date==NULL){
                $end_date=date('Y-m-d',strtotime($start_date."+".($timeframe/86400000)."days"));
            }
        }

        function remove($conn,$id){
            $_SESSION['db_connection']->dml_query($conn,"DELETE FROM tasks WHERE tasks.id =".$id);
            $_SESSION['db_connection']->dml_query($conn,"ALTER TABLE tasks AUTO_INCREMENT=1;");
        }
        function link($id_previous, $id_next){
    
        }
        function unlink($id){
    
        }
        function find($toSearch){
    
        }
    }

?>