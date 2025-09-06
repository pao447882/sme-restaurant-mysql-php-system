<?php
    include "connect_db.php";
    
    $order_id = $_POST['order_id'];

    //echo "Order ID : ".$order_id;
	$sql = "SELECT * FROM order_table WHERE order_id = ".$order_id;
    //echo $sql;
    $result = mysqli_query($conn, $sql);  
    
    $order_detail =  mysqli_fetch_array($result);

    
    echo "Order # ".$order_detail['order_id'];
    echo "<br>Order Date : ".$order_detail['order_date'];
    echo " ".$order_detail['order_time'];
    echo "<br>Place : ".$order_detail['place'];
    echo "<br><br>";	

    $sql = "SELECT * FROM order_detail_menu WHERE order_id = $order_id";
    //echo $sql;
    $result = mysqli_query($conn, $sql);    
    $cnt = 0;

    $itemsPrice = [];

?>

<div id="order-summary" class="menu_list">
		<table class="menu-table">
			<thead>
				<tr>
					<th style="width:20px">#</th>	
					<th style="width:180px">Menu Name</th>
                    <th style="width:45px">Price</th>					
					<th style="width:45px">Qty</th>
					<th style="width:45px">total</th>
				</tr>
			</thead>
			<tbody id="menu-body">
				<?php while ($menu = mysqli_fetch_assoc($result)) { $cnt += 1; ?>				
					<tr>
						<td><?php echo $cnt; ?></td>
						<td><?php echo $menu['menu_name']; ?></td>
                        <td><?php echo $menu['price']; ?></td>
						<td><?php echo $menu['quantity']; ?></td>
    
                        <?php
                            $price = $menu['price'] * $menu['quantity'];
                            array_push($itemsPrice, $price);
                        ?>
						<td><?php echo $price; ?></td>
					</tr>				
				<?php } ?>

                <?php
                    $total_price = array_sum($itemsPrice);
                ?>

                <tr>
                    <td colspan="4" style="text-align: center; font-weight: bold;"> Sum </td>
					<td style="text-decoration: underline; font-weight: bold;"><?php echo $total_price; ?></td>
                </tr>
			</tbody>
		</table>
	</div>	

    <button id="btnPayOrder" onclick="PayOrder()">Pay</button>