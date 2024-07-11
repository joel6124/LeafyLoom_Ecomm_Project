<?php
    include("connection.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $cus_id=$_SESSION['cust_id'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $eid=$_POST['e-id'];
        $ph_no=$_POST['ph_no'];
        $address=$_POST['address'];

        $sql_update_profile = "UPDATE customer SET fname=?, lname=?, Email_address=?, Contact=?, Address=? WHERE Customer_id=?";
        $stmt_up_prof=$conn->prepare($sql_update_profile);
        $stmt_up_prof->bind_param("sssiss",$fname, $lname, $eid, $ph_no, $address, $cus_id);
        $stmt_up_prof->execute();
        $stmt_up_prof->close();

        $_SESSION['username']=$fname;
        echo "<script> window.history.back(); </script>";
    }
?>