<?php
    include "connect_db.php";


    $term = $_POST['term'];


    $query = "SELECT * FROM ingredient WHERE ingredient_name LIKE '%".$term."%' ORDER BY ingredient_name ASC";
    $result = mysqli_query($conn, $query);
    
    $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
    $data = array();

    foreach($result as $row){
        $ingd_name_id = $row['ingredient_name']." (ID : ".$row['ingredient_id']." )";

        $data[] = array(
            'label' => $ingd_name_id,
            'value' => $ingd_name_id,
            'id' => $row['ingredient_id'],
            'unit' => $row['unit']
        );
    }

    echo json_encode($data);

?>