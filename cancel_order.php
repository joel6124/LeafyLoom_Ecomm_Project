<?php
    include("connection.php");
    session_start();

    if (isset($_POST["od_id"])) 
    {
        $cancel="Cancelled";
        $od_id=$_POST['od_id'];
        $sql_can_order="UPDATE order_details SET status=? WHERE order_details.order_detail_id=?";
        $stmt_cancel_order=$conn->prepare($sql_can_order);
        $stmt_cancel_order->bind_param("si", $cancel,$od_id);
        $stmt_cancel_order->execute();
        $stmt_cancel_order->close();
        echo '<script>window.history.back();</script>';
    }
?>