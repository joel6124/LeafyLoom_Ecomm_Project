<?php
    include("connection.php");
    session_start();
    if($_SESSION['userlogin'] == false)
    {
        $alert_message = "Kindly Login to add the product to your cart!!";
        header("location: login_register.php?alert_message=" . urlencode($alert_message));
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $customer_id = $_SESSION['cust_id'];
        $prod_id = $_POST['prod_id'];
        $qnty = $_POST['qnty'];
    
        // Check if the product is already in the cart for the same user
        $check_sql = $conn->prepare('SELECT Qnty FROM cart WHERE Customer_id = ? AND Product_id = ?');
        $check_sql->bind_param('ss', $customer_id, $prod_id);
        $check_sql->execute();
        $check_result = $check_sql->get_result();
        
        if ($check_result->num_rows > 0) 
        {
            $existing_qnty = $check_result->fetch_assoc()['Qnty'];
            $new_qnty = $existing_qnty + $qnty;
    
            $update_sql = $conn->prepare('UPDATE cart SET Qnty = ? WHERE Customer_id = ? AND Product_id = ?');
            $update_sql->bind_param('iss', $new_qnty, $customer_id, $prod_id);
    
            if ($update_sql->execute()) {
                echo "<script>alert('Product added to cart successfully!!'); window.history.back();</script>";
            } 
            else 
            {
                echo "ERROR updating quantity: " . $update_sql->error;
            }
    
            $update_sql->close();
        } 
        else 
        {
            $insert_sql = $conn->prepare('INSERT INTO cart (Customer_id, Product_id, Qnty) VALUES (?, ?, ?)');
            $insert_sql->bind_param('ssi', $customer_id, $prod_id, $qnty);
    
            if ($insert_sql->execute()) 
            {
                echo "<script>alert('Product added to cart successfully!!'); window.history.back();</script>";
            } 
            else 
            {
                echo "ERROR inserting product to cart: " . $insert_sql->error;
            }
    
            $insert_sql->close();
        }
    
        $check_sql->close();
        $conn->close();
    }
    
?>
