<?php
    include "connect_db.php";

    //echo $_POST['emp_name']."<br>";
    //echo $_POST['show_all']."<br>";
    $input_name = $_POST['emp_name'];
   
    if ($_POST['show_all'] == "all") {
        $sql = "SELECT * FROM employee";
    } else {
        $sql = "SELECT * FROM employee WHERE emp_name = '".$input_name."'";
    }

    //echo $sql."<br>";    

    $result = mysqli_query($conn, $sql);    
    $cnt = 0;
?>


<table class="menu-table" style="width:1200px" border="1" >
    <tr>
        <th class = "th_text" style="width:60px">#</th>
        <th class = "th_text" style="width:180px">Employee ID</th>
        <th class = "th_text" style="width:270px">Employee Name</th>
        <th class = "th_text" style="width:180px">Role</th>
        <th class = "th_text" style="width:100px">branch</th>
        <th class = "th_text" style="width:200px">Salary</th>
        <th class = "th_text" style="width:200px">Password</th>
        <th class = "th_text" style="width:240px">Action</th>
    </tr>

    <?php while ($user = mysqli_fetch_assoc($result)) { $cnt += 1; ?>
        <tr>
            <td><?php echo $cnt; ?></td>
            <td><?php echo $user['employee_id']; ?></td>
            <td><?php echo $user['emp_name']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td><?php echo $user['branch']; ?></td>
            <td><?php echo $user['salary']; ?></td>
            <td><?php echo $user['password']; ?></td>

            <?php 
                $name = $user['emp_name'];
                $emp_id = $user['employee_id'];            
            ?> 

            <td>
                <a href="edit_user_account.php?edit_id=<?php echo $emp_id; ?>" style="margin-right: 10;">Edit</a>
                <a href="employee_account.php?delete_id=<?php echo $emp_id; ?>" onclick="return confirm('Are you sure you want to delete user : <?php echo $name; ?> ?')" style="margin-leftt: 10;">Delete</a>                
            </td>
        </tr>
    <?php } ?>
</table>

<?php
    mysqli_close($conn);
?>
