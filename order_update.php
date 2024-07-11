<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include("connection.php");
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        function send_order_confirmation_mail($email,$fname,$od_id,$od_date,$od_address,$od_amt,$od_pay_meth,$ver_code)
        {
            require('PHPMailer/PHPMailer.php');
            require('PHPMailer/SMTP.php');
            require('PHPMailer/Exception.php');

            $mail = new PHPMailer(true);

                
            try 
            {
                //Server settings      
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'leafyloom.ecomm@gmail.com';                     
                $mail->Password   = 'djspuzegdtkqexup';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('leafyloom.ecomm@gmail.com', 'LeafyLoom');
                $mail->addAddress($email, 'LeafyLoom');     //Add a recipient
                //content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Order Confirmation - LeafyLoom';
                $mail->Subject = 'Order Confirmation - LeafyLoom';
                $mail->Body    = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-weight: 600;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #e0e0e0;
                            border-radius: 5px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            background-color: #132A13;
                            color: white;
                            padding: 10px;
                            text-align: center;
                            border-radius: 5px 5px 0 0;
                        }
                        .order-details {
                            margin-top: 20px;
                            padding: 10px;
                            border: 1px solid #e0e0e0;
                            border-radius: 0 0 5px 5px;
                            background-color: #ffffff;
                        }
                        .order-details h2 {
                            color: #132A13;
                            margin-bottom: 10px;
                        }
                        .order-details p {
                            margin: 5px 0;
                        }
                        .footer {
                            margin-top: 20px;
                            text-align: center;
                            color: #666666;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Order Confirmation - LeafyLoom</h1>
                        </div>
                        <div class='intro'>
                            <p>Dear $fname,</p>
                            <p>We are pleased to confirm your recent order with LeafyLoom. Below are the details of your order:</p>
                        </div>
                        <div class='order-details'>
                            <h2>Order Details</h2>
                            <p><strong>Order ID:</strong> $od_id</p>
                            <p><strong>Order Date:</strong> $od_date</p>
                            <p><strong>Shipping Address:</strong> $od_address</p>
                            <p><strong>Total Amount:</strong> ₹ $od_amt</p>
                            <p><strong>Payment Method:</strong> $od_pay_meth</p>
                            <p><strong>Verification Code:</strong> $ver_code</p>
                        </div>
                        <div class='footer'>
                            <p>Thank you for shopping with LeafyLoom. If you have any questions or need further assistance, please don't hesitate to contact our customer support team.</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                

                $mail->send();
                return true;
            } 
            catch (Exception $e) 
            {
                return false;
            }
        }

        function generateUniqueOrderID($conn) 
        {
            // Generate a unique order ID using microtime and random string
            $microtime = microtime(true);
            $random_string = bin2hex(random_bytes(4));
            $order_id = "ORD-" . $microtime . "-" . $random_string;
            return $order_id;
        }
        
        Function generateUniqueVerificationCode($conn) 
        {
            $verification_code = generateVerificationCode();
            $sql_check_code = "SELECT COUNT(*) AS count FROM orders WHERE verification_code = ?";
            $stmt_check_code = $conn->prepare($sql_check_code);
            $stmt_check_code->bind_param("s", $verification_code);
            $stmt_check_code->execute();
            $result_check_code = $stmt_check_code->get_result();
            $count = $result_check_code->fetch_assoc()['count'];
            $stmt_check_code->close();

            // Generate a new code if not unique
            while ($count > 0) 
            {
                $verification_code = generateVerificationCode();
                $stmt_check_code = $conn->prepare($sql_check_code);
                $stmt_check_code->bind_param("s", $verification_code);
                $stmt_check_code->execute();
                $result_check_code = $stmt_check_code->get_result();
                $count = $result_check_code->fetch_assoc()['count'];
                $stmt_check_code->close();      
            }
            return $verification_code;
        }

        function generateVerificationCode() 
        {
            // Generate a verification code
            $verification_code = substr(uniqid('VC'), 0, 10);
            return $verification_code;
        }



        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $order_confirm=false;
            $order_id = generateUniqueOrderID($conn);
            // echo $order_id;
            $customer_id = $_POST['customer_id'];
            $total_amount = $_POST['total_amount'];
            $payment_mode = $_POST['payment_mode'];
            $points_redeemed = isset($_POST['points_redeemed']) ? $_POST['points_redeemed'] : null;
            $verification_code = generateUniqueVerificationCode($conn);
            $conn->begin_transaction();

            try 
            {
                $sql_order = "INSERT INTO orders (order_id,customer_id, order_date, total_amount, points_redeemed, mode_of_payment, verification_code) 
                            VALUES (?,?, NOW(), ?, ?, ?, ?)";
                $stmt_order = $conn->prepare($sql_order);
                $stmt_order->bind_param("ssdsss",$order_id, $customer_id, $total_amount, $points_redeemed, $payment_mode, $verification_code);
                $stmt_order->execute();
                // $order_id = $stmt_order->insert_id;
                // echo 'inseted';
                
                $stmt_order->close();

                // Update rewards table if points_redeemed is not null
                if ($points_redeemed !== null) 
                {
                    $sql_update_rewards = "UPDATE rewards SET Points = Points - ? WHERE Customer_id = ?";
                    $stmt_update_rewards = $conn->prepare($sql_update_rewards);
                    $stmt_update_rewards->bind_param("is", $points_redeemed, $customer_id);
                    $stmt_update_rewards->execute();
                    $stmt_update_rewards->close();
                }

                $sql_fetch_cart = "SELECT cart.Product_id AS prod_id, discounted_price, Qnty FROM cart INNER JOIN products ON cart.Product_id = products.Product_id WHERE cart.Customer_id=?";
                $stmt_fetch_cart = $conn->prepare($sql_fetch_cart);
                
                if ($stmt_fetch_cart) 
                {
                    $stmt_fetch_cart->bind_param("s", $customer_id);
                    $stmt_fetch_cart->execute();
                    $result_cart = $stmt_fetch_cart->get_result();
                
                    while ($cart_item = $result_cart->fetch_assoc()) 
                    {
                        $pid = $cart_item["prod_id"];
                        $qnty_p = $cart_item["Qnty"];
                        $price = $cart_item["discounted_price"];
                        $pending="Pending";
                        $sub_total_p= $qnty_p*$price;
                
                        $sql_order_detail = "INSERT INTO order_details (order_id, product_id, quantity, price, status) VALUES (?, ?, ?, ?, ?)";
                        $stmt_order_detail = $conn->prepare($sql_order_detail);
                
                        if ($stmt_order_detail) 
                        {
                            $stmt_order_detail->bind_param("ssids", $order_id, $pid, $qnty_p, $sub_total_p, $pending);
                            $stmt_order_detail->execute();
                            $stmt_order_detail->close();
                        } 
                        else 
                        {
                            echo "Failed to prepare order detail statement.";
                        }
                    }
                
                    $stmt_fetch_cart->close();
                } 
                else 
                {
                    echo "Failed to prepare cart fetch statement.";
                }
                
                $address = $_POST['address'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ' ' . $_POST['pincode'];
                $sql_delivery = "INSERT INTO deliveries (order_id, deliver_to_address, delivery_date) 
                                VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY))";
                $stmt_delivery = $conn->prepare($sql_delivery);
                $stmt_delivery->bind_param("ss", $order_id, $address);
                $stmt_delivery->execute();
                $stmt_delivery->close();
                $conn->commit();

                $order_confirm=true;
            
            } 
            catch (Exception $e) 
            {
                // Rollback the transaction in case of any error
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }

            if($order_confirm)
            {
                $sql_fetch_order_address = "SELECT o.*, d.deliver_to_address 
                               FROM orders o 
                               INNER JOIN deliveries d ON o.order_id = d.order_id 
                               WHERE o.order_id = ?";
                $stmt_fetch_order_address = $conn->prepare($sql_fetch_order_address);
                $stmt_fetch_order_address->bind_param("s", $order_id);
                $stmt_fetch_order_address->execute();
                $result_order_address = $stmt_fetch_order_address->get_result();
    
                if ($result_order_address->num_rows > 0) 
                {
                    $row = $result_order_address->fetch_assoc();
                    $od_date = $row["order_date"];
                    $od_amt = $row["total_amount"];
                    $od_address = $row["deliver_to_address"];
                    $od_pay_meth= $row['mode_of_payment'];

                    $cust_id=$row['customer_id'];
                    $sql_get_cust_det="SELECT fname,Email_address FROM customer WHERE Customer_id='$cust_id'";
                    $result = mysqli_query($conn, $sql_get_cust_det);
                    $row = mysqli_fetch_assoc($result);
                    $email=$row['Email_address'];
                    $fname=$row['fname'];

                    send_order_confirmation_mail($email,$fname,$order_id,$od_date,$od_address,$od_amt,$od_pay_meth,$verification_code);
                    echo '<div class="popup-order-placed">
                            <div class="img_div">
                                <img src="img/order-placed-purchased-icon.jpg" alt="" width="90" height="90">
                            </div>
                            <h2>Order Placed!</h2>
                            <p>Your verification code is: '. $verification_code . '</p>
                            <p>Thank You! Continue Shopping with Us!</p>
                            <button type="button">OK</button>
                        </div>';
                }
                $stmt_fetch_order_address->close();
            }
        }
        
    ?>
    <script>
            document.addEventListener("DOMContentLoaded", function() 
            {
                var okButton = document.querySelector(".popup-order-placed button");
                okButton.addEventListener("click", close_popup);
            });

        function close_popup() 
        {
            window.location.href = 'index.php';
        }

    </script>

</body>
</html>