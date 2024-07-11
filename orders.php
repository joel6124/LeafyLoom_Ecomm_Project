<?php
    include("connection.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafyLoom - Order History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    


    <style>
        
        #order-history h2
        {
            margin-bottom: 20px;
        }

        #order-history .overlay
        {
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #132A13;
            /* background-color: #ECF39E; */
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        #order-history .overlay span
        {
            display: block;
            /* text-align: : right; */
        }
        #order-history .overlay #o_id
        {
            text-align: right;
        }
        #order-history .overlay #o_id span
        {
            margin-left: 40px;
        }
        #order-history .order
        {
            width: 100%;
            height: 170px;
            margin-bottom: 80px;
        }
        #order-history .order p
        {
            color: white;
        }
        #order-history .order_cont
        {
            background-color: #e2e4e9;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content:space-around;
            align-items: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        #order-history .order_cont img
        {
            border-radius: 10px;
        }
        #order-history .order .order_del_det
        {
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
        }
        #order-history .order #success
        {
            font-size: 18px;
            color: #4F772D;
            font-weight: bolder;
        }
        #order-history .order #on_the_way
        {
            font-size: 18px;
            color: #af6d09;
            font-weight: bolder;
        }
        #order-history .order #cancelled
        {
            font-size: 18px;
            color: #7a1204;
            font-weight: bolder;
        }
        #order-history .order .order_del_det h6
        {
            font-size: 15px;
            font-weight: bold;
            color: #132A13;
            padding: 10px 0;
        }
        #order-history .order .order_del_det a
        {
            color: #ebb512;
            text-decoration: none;
            font-weight: bold;
            font-size: 17px;
        }
        #order-history .order .order_del_det i
        {
            font-size: 14px;
            padding-right: 5px;
        }
        #order-history .order .order_del_det button
        {
            background-color: transparent;
            color: rgb(130, 17, 17);
            border: 1.5px solid rgb(130, 17, 17);
            margin-top: 20px;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold; 
        }

    </style>
</head>
<body>

    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="LeafyLoom" width="120" height="120"></a>
        <!-- <a id="logo" href="home.html">LeafyLoom</a> -->
        <div id="navbar">
            <ul id="navbar" class="center-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#aboutus">About</a></li>
                <li><a href="shop.php?cat=all">Shop</a></li>
                <li><a href="community_wareness.php">Community & Awareness</a></li>
                <li><a href="rewards.php">Rewards</a></li>
                <li><a href="#footer">Contact Us</a></li>
            </ul>
            <ul id="navbar" class="side-nav">
                <li><a href="<?php echo isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true ? '#' : 'login_register.php'; ?>" id="user_pf"><i class="fa-solid fa-user"></i>
                    <?php
                        if(isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true)
                        {
                            echo "<h5>Hi, " . $_SESSION['username'] . "</h5>";
                        }
                        else
                        {
                            echo "<h5>Login</h5>";
                        }
                    ?>
                </a></li>
                <li id="cart_icon"><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <span id="cart_num">
                    <?php 
                        if(isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true)
                        {
                            $cus_id=$_SESSION['cust_id'];
                            $sql_cart_no="SELECT SUM(Qnty) AS cart_qnty FROM cart WHERE Customer_id='$cus_id'";
                            $cart_no=$conn->query($sql_cart_no);
                            $cart_tot=$cart_no->fetch_assoc();
                            echo $cart_tot['cart_qnty'];
                            if($cart_tot['cart_qnty']==0)
                            {
                                echo '0';
                            }
                        }
                        else
                        {
                            echo '0';
                        }
                    ?>
                </span>
                </li>
            </ul>
            
            <?php
                if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
                {
                    echo '<div class="sub-menu-wrap" id="subMenu">
                            <div class="sub-menu">
                                <div class="user-info">
                                    <img src="img/team-1.jpg" alt="">
                                    <h5>' . $_SESSION['username'] . '</h5>
                                </div>
                                <hr>
                                <a href="orders.php" class="sub-menu-link"><i class="fa-solid fa-folder-minus"></i><p>Orders</p><i class="fa-solid fa-caret-right"></i></a>
                                <a href="profile.php" class="sub-menu-link"><i class="fa-solid fa-user"></i><p>Profile</p><i class="fa-solid fa-caret-right"></i></a>
                                <a href="logout.php" class="sub-menu-link"><i class="fa-solid fa-right-from-bracket"></i><p>Logout</p><i class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>';
                }
            ?>

        </div>

    </section>
    
    <?php
        $status_chk="Delivered";
        $cancel="Cancelled";
        $sql_update_status = "UPDATE order_details 
                      JOIN deliveries ON order_details.order_id = deliveries.order_id
                      SET order_details.status = ?
                      WHERE CURDATE() > deliveries.delivery_date 
                      AND order_details.status != ?";
        $stmt_update_status=$conn->prepare($sql_update_status);
        $stmt_update_status->bind_param("ss",$status_chk,$cancel);
        $stmt_update_status->execute();
        $stmt_update_status->close();
        // $conn->close();
    ?>


    <section id="order-history" class="section-p1">
    <h2>Order History</h2>
    <?php
        $customer_id = $_SESSION['cust_id'];
        $sql_fetch_orders = "SELECT orders.order_date, orders.order_id 
            FROM orders 
            INNER JOIN deliveries ON orders.order_id = deliveries.order_id 
            WHERE orders.customer_id = ? 
            ORDER BY deliveries.delivery_date DESC";
        $stmt_fetch_orders = $conn->prepare($sql_fetch_orders);
        $stmt_fetch_orders->bind_param("s", $customer_id);
        $stmt_fetch_orders->execute();
        $result = $stmt_fetch_orders->get_result();
        $stmt_fetch_orders->close();

        if ($result->num_rows > 0) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $o_id = $row['order_id'];
                $sql_ordered_prod = "SELECT order_details.order_detail_id as od_id, deliveries.delivery_id as del_id, order_details.product_id as p_id, products.Img1 as img, products.Product_brand as brand, products.Product_name as prod_name, order_details.quantity as qnty, order_details.price as price, deliveries.delivery_date as del_date, order_details.status as sts 
                    FROM order_details
                    INNER JOIN products ON order_details.product_id=products.Product_id
                    INNER JOIN deliveries ON order_details.order_id=deliveries.order_id
                    WHERE order_details.order_id=?";
                $stmt_ordered_prod = $conn->prepare($sql_ordered_prod);
                $stmt_ordered_prod->bind_param("s", $o_id);
                $stmt_ordered_prod->execute();
                $result_order = $stmt_ordered_prod->get_result();

                $grouped_products = []; // Array to store grouped products by product name
                while ($row_order = $result_order->fetch_assoc()) 
                {
                    $prod_name = $row_order['prod_name'];
                    if (!isset($grouped_products[$prod_name])) 
                    {
                        $grouped_products[$prod_name] = [];
                    }
                    $grouped_products[$prod_name][] = $row_order;
                }

                foreach ($grouped_products as $prod_name => $products) 
                {
                    $orderDate = $row['order_date'];
                    $dateObj = new DateTime($orderDate);
                    $formattedDate = $dateObj->format('F d, Y');
                    echo '<div class="order">';
                    echo '<div class="overlay"><p>Order Placed on: <span>' . $formattedDate . '</span></p> <p id="o_id">Order ID: <span>' . $row['order_id'] . '</span></p></div>';
                    echo '<div class="order_cont">';
                    foreach ($products as $product) 
                    {
                        echo '<img src="' . $product['img'] . '" alt="imag" width="80" height="90">';
                        echo '<div class="prod">';
                        echo '<h3>' . $product['brand'] . '</h3>';
                        echo '<h4>' . $product['prod_name'] . '</h4>';
                        echo '</div>';
                        echo '<div class="prod" style="text-align: center;">';
                        echo '<h3>Qty</h3>';
                        echo '<h4>' . $product['qnty'] . '</h4>';
                        echo '</div>';
                        echo '<h3>₹' . $product['price'] . '</h3>';
                        echo '<div class="order_del_det">';
                        $delDate = $product['del_date'];
                        $deldateObj = new DateTime($delDate);
                        $formatteddelDate = $deldateObj->format('F d, Y');
                        if($product['sts']=="Delivered")
                        {
                            echo '<h4 id="success">Delivered on ' . $formatteddelDate . '</h4>';
                            echo '<h6>Your item has been delivered</h6>';
                            echo '<a href="prod_details.php?id=' . $product['p_id'] . '"> <i class="fa-solid fa-star"></i> Rate & Review Product</a>';
                        }
                        if($product['sts']=="Pending")
                        {
                            echo '<h4 id="on_the_way">Order On The Way </h4>';
                            echo '<h6>Your item will be delivered by ' . $formatteddelDate . ' </h6>';
                            echo '<a href="prod_details.php?id=' . $product['p_id'] . '"> <i class="fa-solid fa-star"></i> Rate & Review Product</a>';
                            echo '<div class="cancel_order_div">    
                                <form onsubmit="return confirmCancel();" action="cancel_order.php" method="post">
                                    <input type="hidden" id="od_id" name="od_id" value="' .$product['od_id'] . '">
                                    <button><i class="fa-solid fa-trash-can"></i>CANCEL</button>
                                </form>
                        
                                    </div>';
                        }
                        if($product['sts']=="Cancelled")
                        {
                            echo '<h4 id="cancelled">Item Cancelled </h4>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                $stmt_ordered_prod->close();
            }
        } 
        
        else {
            echo '<h3>No orders!!</h3>';
        }
    ?>


    </section>

    
    <section id="footer">
        <footer>
            <div class="footer">
                <div class="col">
                    <img class="logo" src="img/logo.png" alt="">
                </div>
                <div class="col">
                    <h4>Contact</h4>
                    <p><strong>Address:</strong> Christ University, Banglore </p>
                    <p><strong>Phone: </strong>+91 73495 70773</p>
                </div>
                <div class="col">
                    <h4>Follow us</h4>
                    <div class="icon">
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-youtube"></i>
                        <i class="fa-brands fa-x-twitter"></i>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2024 LeafyLoom. All rights reserved.</p>
            </div>
        </footer>
    </section>
    <script src="script.js"></script>
    <script>
        function confirmCancel() 
        {
            if (confirm("Are you sure you want to cancel the order?")) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }

    </script>

</body>
</html>
