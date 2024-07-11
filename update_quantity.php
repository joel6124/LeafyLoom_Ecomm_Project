<?php
    include("connection.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
    {
        $productId = $_GET['prod_id'];
        $newQuantity = $_POST['quantity'];
        $customerId = $_SESSION['cust_id'];
        echo $productId . $newQuantity . $customerId;
        $stmt = $conn->prepare("UPDATE cart SET Qnty = ? WHERE Product_id = ? AND Customer_id = ?");
        $stmt->bind_param("iss", $newQuantity, $productId, $customerId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: cart.php");
        exit();
    } 
    else 
    {
        header("Location: login_register.php");
        exit();
    }
?>
