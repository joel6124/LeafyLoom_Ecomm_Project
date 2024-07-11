<?php
    include("connection.php");
    session_start();
    $prod_id="";
    if(isset($_GET['prod_id']))
    {
        $prod_id=$_GET['prod_id'];
    }
    $cus_id=$_SESSION['cust_id'];
    $sql="DELETE FROM cart where Product_id='$prod_id' and Customer_id='$cus_id';";
    if($conn->query($sql))
    {
        echo "<script>alert('Product Removed form cart!!'); window.location.href='cart.php';</script>";
    }
    $conn->close();
?>