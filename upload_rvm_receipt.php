<?php
    include("connection.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_SESSION['cust_id'])) 
        {
            try 
            {
                $conn->begin_transaction();

                $customer_id = $_SESSION['cust_id'];
                $verification_code = $_POST['verification-code'];
                $verification_code_claimed_chk = 'NO';
                $sql_chk_eligible = "SELECT * FROM orders WHERE customer_id=? AND verification_code=? AND verification_code_claimed=?";
                $stmt_chk = $conn->prepare($sql_chk_eligible);
                $stmt_chk->bind_param("sss", $customer_id, $verification_code, $verification_code_claimed_chk);
                $stmt_chk->execute();

                $result = $stmt_chk->get_result();
                $stmt_chk->close();

                if ($result->num_rows > 0) 
                {
                    $uploadsDirectory = 'RVM_images/';
                    $fileName = $_FILES['rvm-rec']['name'];
                    $destination = $uploadsDirectory . $fileName;

                    $uploadedFile = $_FILES['rvm-rec']['tmp_name'];

                    if (move_uploaded_file($uploadedFile, $destination)) {
                        $stmt_insert_db = $conn->prepare("INSERT INTO rvm_images (Customer_id, Img_path) VALUES (?, ?)");
                        $stmt_insert_db->bind_param("ss", $customer_id, $destination);
                        $stmt_insert_db->execute();
                        $stmt_insert_db->close();

                        $code_claimed = "YES";
                        $stmt_update_db = $conn->prepare("UPDATE orders SET verification_code_claimed=? WHERE verification_code=?");
                        $stmt_update_db->bind_param("ss", $code_claimed, $verification_code);
                        $stmt_update_db->execute();
                        $stmt_update_db->close();

                        $stmt_update_pts = $conn->prepare("UPDATE rewards SET Points = Points + 30 WHERE Customer_id = ?");
                        $stmt_update_pts->bind_param("s", $customer_id);
                        $stmt_update_pts->execute();
                        $stmt_update_pts->close();

                        $conn->commit();

                        echo "<script>alert('Congrats!!...Your Points has been updated to your profile!');  window.history.back();</script>";
                    } 
                    else 
                    {
                        echo "Error uploading file!!";
                    }
                } 
                else 
                {
                    echo "<script> alert('Sorry!..You will need to order atleast an item to participate or you would have already claimed with the same verification code or would have entered a wrong verification code!'); window.history.back();</script>";
                }
            } 
            catch (Exception $e) 
            {
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            } 
            finally 
            {
                $conn->close();
            }
        } 
        else 
        {
            echo "<script>alert('Please SignUp/Login to Upload your receipt!!'); window.history.back();</script>";
        }
    }
?>
