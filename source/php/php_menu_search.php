<?php
    include "connect_db.php";

    if (isset($_GET['term'])) {
        $term = $_GET['term'];
    
        $query = "SELECT * FROM menu WHERE menu_name LIKE '%".$term."%' ORDER BY menu_name ASC";
        $result = mysqli_query($conn, $query);
        
        $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
        $name_list = array();

        foreach($data as $name){
            $name_list[] = $name['menu_name'];
        }
    
        echo json_encode($name_list);
    }
?>