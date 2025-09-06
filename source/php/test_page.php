<?php
    include "connect_db.php";

    // Update Ingredeint data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ingd_id = $_POST['id'];
        $column = $_POST['column'];
        $new_value = floatval($_POST['new_value']);
        $user_id = ($_POST['user_id']);

        // Update the specific cell in the database
        $update_query = "UPDATE ingredient SET $column=".$new_value.", employee_id = ".$user_id.", update_time = now() WHERE ingredient_id = ".$ingd_id;
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "success";
            exit();
        } else {
            echo "Error updating user data: " . mysqli_error($conn);
            exit();
        }
    }
?>

<script>
    var sql_text = <?php echo $update_query ?> ;
    console.log(sql_text);
</script>
