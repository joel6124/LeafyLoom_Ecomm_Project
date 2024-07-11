<?php
    require('connection.php');
    if(isset($_GET['email']) && isset($_GET['ver_code']))
    {
        $email=$_GET['email'];
        $ver_code=$_GET['ver_code'];
        $email_verify="SELECT * FROM customer WHERE Email_address=? AND verification_code=?";
        $stmt_email_verify=$conn->prepare($email_verify);
        $stmt_email_verify->bind_param("ss", $email, $ver_code);
        $stmt_email_verify->execute();
        $result = $stmt_email_verify->get_result();
        $stmt_email_verify->close();
        if($result->num_rows==1)
        {
            $row = $result->fetch_assoc();
            if($row['is_verified']==0)
            {
                $em_id=$row['Email_address'];
                $is_veri=1;
                $update_email_ver="UPDATE customer SET is_verified=? WHERE Email_address=?";
                $stmt_update_email_ver=$conn->prepare($update_email_ver);
                $stmt_update_email_ver->bind_param("is", $is_veri, $em_id);
                $stmt_update_email_ver->execute();
                $stmt_update_email_ver->close();
                echo "<script>alert('Your Email Verification is Successfull!!'); window.location.href = 'index.php';</script>";

            }
            else
            {
                echo "<script>alert('Your Email has already been Verified!!'); window.location.href = 'index.php';</script>";
            }
        }
        else
        {
            echo "<script>alert('Query not correct!'); window.location.href = 'index.php';</script>";
        }
    }
?>