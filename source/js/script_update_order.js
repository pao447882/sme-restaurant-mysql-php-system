function updateOrder() {
    const orderData = [];

    const menuRows = document.querySelectorAll('.menu-table tbody tr');    

    menuRows.forEach((row, index) => {
        const itemId = row.cells[0].textContent;
        const itemName = row.cells[1].textContent;
        const quantity = document.getElementById(`quantity${index}`).value;               


        //var remark_txt = document.getElementById(`remark${index}`).value;
        //console.log(remark_txt);
        const remark = remark_txt = document.getElementById(`remark${index}`).value;


        const extra = extra_order;

        if (quantity > 0) {
            orderData.push({ item_id : parseInt(itemId,10), item_name : itemName, quantity: parseInt(quantity, 10),  extra : extra, remark : remark });
            //orderData.push({ item_id : itemId, item_name : itemName, quantity: parseInt(quantity, 10), extra : extra, });
        }
    });

    // Display the order summary
    displayOrderSummary(orderData);
}

function displayOrderSummary(orderData) {
    const summaryList = document.getElementById('summary-list');
    summaryList.innerHTML = '';

    // Display Place 
    const place = document.getElementById('txtPlace').value;

    var orderDetail = [];
    
   
    const li = document.createElement('li');
    li.textContent = `Employee ID : ${emp_id}`;
    //console.log(document.getElementById('txtPlace').value);
    summaryList.appendChild(li);

    const li_place = document.createElement('li');
    li_place.textContent = `Place : ${document.getElementById('txtPlace').value}`;
    //console.log(document.getElementById('txtPlace').value);
    summaryList.appendChild(li_place);

    orderData.forEach(orderItem => {
        const li = document.createElement('li');
        li.textContent = `${orderItem.item_id} ${orderItem.item_name} : qty(${orderItem.quantity}) ${orderItem.extra} ${orderItem.remark}`;
        summaryList.appendChild(li);
    });

    orderDetail.push({EmpID : emp_id, Place : place});
    console.log(orderDetail);
    console.log(orderData);

    // Optionally, you can send the order data to the server for further processing
    saveOrderToDatabase(orderData, orderDetail);

    // Display a modal or redirect to a confirmation page, etc.
    const orderSummary = document.getElementById('order-summary');
    orderSummary.style.display = 'flex';

    const btnCheckout = document.getElementById('btnCheckout');
    btnCheckout.style.display = 'none';

    const menu_container = document.getElementById('menu_container');
    menu_container.style.display = 'none';
}

function saveOrderToDatabase(orderData, orderDetail) {
    // Convert the orderData to a JSON string
    const jsonData = JSON.stringify({orderData, orderDetail});

    // Make an AJAX request to the server
    fetch('php/php_save_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: jsonData,
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        console.log(data.message); // Log the server response (e.g., success message)
        // You can also update the UI or perform additional actions based on the response
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch
        console.error('Error:', error);
        // You might want to display an error message to the user or log the error for debugging
    });
}
