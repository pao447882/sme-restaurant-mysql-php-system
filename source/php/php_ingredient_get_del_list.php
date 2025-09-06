<?php
    include "connect_db.php";
   
    #"Show All : ";
    //echo $_POST['show_all']."<br>";
    //echo $_POST['user_role']."<br>";
    $user_role = $_SESSION['Role']; 

    $emp_id = $_POST['emp_id'];

    $sql = "SELECT MAX(update_time) FROM ingredient";	
    $sqlQuery = mysqli_query($conn, $sql);
	$objResult = mysqli_fetch_array($sqlQuery);
					
	$last_update = $objResult[0];

    if ($_POST['show_all'] == "all") {
        $sql = "SELECT * FROM ingredient LEFT JOIN employee USING (employee_id) ORDER BY ingredient_name";
    } else {
        $sql = "SELECT * FROM ingredient LEFT JOIN employee USING (employee_id) WHERE ingredient_name = '".$_POST['ingd_name']."' ORDER BY ingredient_name";
    }
    
   //echo $sql;

    $sqlQuery = mysqli_query($conn,$sql);

    $cnt = 0;
?>

<div style = "text-align : center;">
    <?php echo "Last Update : ".$last_update; ?>
</div>

<br>
<table class="center" style="width:1000px" border="1">
    <thead>
        <tr>
            <th class = "th_text" style="width:60px">#</th>
            <th class = "th_text" style="width:120px">Ingredient ID</th>
            <th class = "th_text" style="width:270px">Name</th>
            <th class = "th_text" style="width:110px">Unit</th>
            <th class = "th_text" style="width:90px">Cost / Unit</th>
            
            <?php 
                if($_POST['user_role'] == "admin") {
                    echo '<th class = "th_text" style="width:120px">Edit By</th>';
                    echo '<th class = "th_text" style="width:165px">Time</th>';    
                }
            ?>

            <th class = "th_text" style="width:90px">Action</th>
        </tr>
    </thead>              
    <tbody>         
        <?php   while($row = mysqli_fetch_assoc($sqlQuery)) { $cnt += 1; ?>
        <tr>
            <td><?php echo $cnt; ?></td>
            <td><?php echo $row['ingredient_id']; ?></td>
            <td><?php echo $row['ingredient_name']; ?></td>
            <td><?php echo $row['unit']; ?></td>
            <td class="editable" data-id="<?php echo $row['ingredient_id']; ?>" data-column="cost_per_unit"><?php echo $row['cost_per_unit']; ?></td>
            <?php 
                if($_POST['user_role'] == "admin") {
                    echo "<td>".$row['emp_name']."</td>";
                    echo "<td>".$row['update_time']."</td>";    
                }
            ?>          
            

            <td>
                <a href="delete_ingredient.php?delete_id=<?php echo $row['ingredient_id']; ?>" onclick="return confirm('Are you sure you want to delete Ingredient : <?php echo $row['ingredient_name']; ?> ?')">Delete</a>
            </td>
        </tr>
            
            

        <?php } ?>

    </tbody>
</table>

<script>
    $(document).ready(function() {
        $(".editable").click(function() {
            var id = $(this).data("id");
            var column = $(this).data("column");
            var currentValue = $(this).text();
            var UserId = <?php echo $emp_id ;?>

            console.log("ID : " + id);
            console.log("val : " + currentValue);

            console.log("Emp ID : " + UserId);

            var newValue = prompt("Enter new value for " + column, currentValue);

            if (newValue !== null) {
                // Update the cell via AJAX
                $.ajax({
                    type: "POST",
                    url: "php/test_page.php",
                    data: {
                        id: id,
                        column: column,
                        new_value: newValue,
                        user_id : UserId
                    },
                    success: function(response) {
                        if (response === "success") {
                            alert("Data updated successfully!");
                            //location.reload();
                            $("#btnIngd").click();
                        } else {
                            alert("Error updating data: " + response);
                        }
                    }
                });
            }
        });
    });
</script>


 <?php 
    if(mysqli_num_rows($sqlQuery) == 0){
        echo '<h3 style = "text-align: center;">Ingredient Not Found </h3>';
    }
?>