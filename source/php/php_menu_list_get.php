<?php
    include "connect_db.php";
    session_start();

    $user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];
    /*echo "Session : ".$_SESSION['Role'];
    echo "<br>";
    echo "ID : ".$_SESSION['Employee_id'];*/
   
    #"Show All : ";
    //echo $_POST['show_all']."<br>";
    //echo $_POST['user_role']."<br>";
    $emp_id = $_POST['emp_id'];
  
    $branch = $_POST['branch'];
					
	$last_update = $objResult[0];

    if (($_POST['show_all'] == "all") && ($branch == 0)) {
        $sql = "SELECT * FROM menu ORDER BY branch_available AND menu_name";
    } elseif (($_POST['show_all'] == "all") && ($branch != 0)) {
        $sql = "SELECT * FROM menu WHERE branch_available = ".$branch." ORDER BY branch_available AND menu_name";
    } elseif (($_POST['show_all'] != "all") && ($branch == 0)) {
        $sql = "SELECT * FROM menu WHERE menu_name = '".$_POST['menu_name']."' ORDER BY branch_available AND menu_name";
    } else {
        $sql = "SELECT * FROM menu WHERE menu_name = '".$_POST['menu_name']."' AND  branch_available = ".$branch." ORDER BY branch_available AND menu_name";
    }
    
    //echo $sql;

    $sqlQuery = mysqli_query($conn,$sql);

    $cnt = 0;
?>

<table class="menu-table" style="width:1000px" border="1">
    <thead>
        <tr>
            <th class = "th_text" style="width:60px">#</th>
            <th class = "th_text" style="width:80px">Menu ID</th>
            <th class = "th_text" style="width:300px">Menu Name</th>
            <th class = "th_text" style="width:110px">Price</th>
            <th class = "th_text" style="width:180px">Branch Available</th>
                    
            <?php 
                if($user_role == "owner") {
                    echo '<th class = "th_text" style="width:120px">Recipe</th>';
                    echo '<th class = "th_text" style="width:120px">Action</th>';
                }
            ?>

        </tr>
    </thead>              
    <tbody>         
        <?php   while($row = mysqli_fetch_assoc($sqlQuery)) { $cnt += 1; ?>
        <tr>
            <td><?php echo $cnt; ?></td>
            <td><?php echo $row['menu_id']; ?></td>
            <td><?php echo $row['menu_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['branch_available']; ?></td>

            <?php 
                if($user_role == "owner") {

                    echo '<td><a href="recipe_page.php?menu_id='.$row['menu_id'].'">Recipe</a></td>';



                    $msg_confirm = "'Are you sure you want to delete Menu: ".$row['menu_name']." ?'";
                    echo '<td><a href="menu_list_edit.php?delete_id='.$row['menu_id'].'" onclick="return confirm('.$msg_confirm.')" style="margin-leftt: 10;">Delete</a></td>';
                }
            ?>

            
         </tr>


        <?php } ?>

    </tbody>
</table>



<?php 
    if(mysqli_num_rows($sqlQuery) == 0){
        echo '<h3 style = "text-align: center;">Ingredient Not Found </h3>';
    }
?>