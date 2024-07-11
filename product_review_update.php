<?php
    include("connection.php");
    session_start();

    if($_SESSION['userlogin'] == false)
    {
        $alert_message = "Kindly Login!!";
        header("location: login_register.php?alert_message=" . urlencode($alert_message));
        exit();
    }


    if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
    {

        $cust_id=$_SESSION['cust_id'];
        $prod_id=$_POST['prod_id'];
        $user_review=$_POST['user_review'];
        $rating=$_POST['rating'];

        $sql = "SELECT * FROM orders,order_details WHERE orders.order_id=order_details.order_id AND orders.customer_id=? AND order_details.product_id=?";
        $chk_rev_post = $conn->prepare($sql);
        $chk_rev_post->bind_param("ss", $cust_id,$prod_id);
        $chk_rev_post->execute();
        $result = $chk_rev_post->get_result();
        if($result->num_rows > 0)
        {
            $sql = "INSERT INTO feedback (Customer_id, Product_id, Ratings, Reviews) VALUES (?,?,?,?);";
            
            // Prepare and bind the statement
            $r_upd = $conn->prepare($sql);
            $r_upd->bind_param("ssis", $cust_id,$prod_id, $rating, $user_review);
            if ($r_upd->execute()) 
            {
                echo "<script>alert('Thank You for the review!'); window.history.back();</script>";
            }
            else 
            {
                echo "<script>alert('Error submitting review!'); window.history.back();</script>";
            }
        }
        else
        {
            echo "<script> alert('Purchase the Product to review it!!'); window.history.back(); </script>";
        }
        $r_upd->close();
        $conn->close();
    }
?>