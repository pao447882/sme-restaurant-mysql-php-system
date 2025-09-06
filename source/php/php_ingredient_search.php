<?php
    include "connect_db.php";

    if (isset($_GET['term'])) {
        $term = $_GET['term'];
    
        $query = "SELECT ingredient_name FROM ingredient WHERE ingredient_name LIKE '%".$term."%' ORDER BY ingredient_name ASC";
        $result = mysqli_query($conn, $query);
        
        $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
        $name_list = array();

        foreach($data as $name){
            $name_list[] = $name['ingredient_name'];
        }
    
        echo json_encode($name_list);
    }
?>