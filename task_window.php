<!-- incarichi: in questa categoria saranno presenti i tasti per manipolazione dei vari incarichi, i tasti saranno: Inserisci, Elimina, Collega, Scollega, Trova; -->

<?php
    session_start();
    require "database_connection.php";
    class Task_Window{
        function add($conn,$id, $name, $timeframe, $start_date, $end_date, $link=NULL,$percentage){
            (new Task_Window())->calc_dates($timeframe, $start_date, $end_date);
            $_SESSION["db_connection"]->dml_query($conn,"INSERT INTO tasks (id, name, timeframe, start_date, end_date, link, project, percentage) VALUES (".$id.", '".$name."', ".$timeframe.", '".$start_date."', '".$end_date."', ".$link.", ".$_SESSION['project_id'].", ".$percentage.")");
        }
        
        function calc_dates(&$timeframe, &$start_date, &$end_date){
            if(!isset($timeframe)){
                if(isset($start_date) && isset($end_date)){
                    floor((strtotime($start_date) - strtotime($end_date)) * 1000); //Trasforma il risulato in secondi in millisecondi
                }
                else{
                    $timeframe=1;
                }
            }
            if(!isset($start_date)){
                if(isset($end_date)){
                    $start_date=date('Y-m-d',strtotime($end_date."-".$timeframe));
                }
                else{
                    $start_date=date('Y-m-d');
                }
            }
            if(!isset($end_date)){
                  $end_date=date('Y-m-d',strtotime($start_date."+".$timeframe));
            }
        }

        function remove($id){
    
        }
        function link($id_previous, $id_next){
    
        }
        function unlink($id){
    
        }
        function find($toSearch){
    
        }
    }

?>