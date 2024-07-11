<?php
    include("connection.php");
    session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafyLoom</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
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
                <li id="cart_icon"><a class="active" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

    <section id = "cart" class = "section-p1">
        <h2>Shopping Cart</h2>
        <?php
        if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
        {
            $sql = "SELECT Img1 as img,cart.Product_id as prod_id ,Product_brand, Product_name, Price, discounted_price, Qnty FROM cart,products WHERE cart.Product_id=products.Product_id AND cart.Customer_id=?";
            
            // Prepare and bind the statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_SESSION['cust_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 0) {
                echo '<div id="cart-empty-message" class="section-p1">
                        <p>Cart is Empty!</p>
                    </div>';
            } else {
                echo '<div id="cart-table-container">
                        <table width = "100%">
                            <thead>
                                <tr>   
                                    <th colspan="2" class="th_spl">Item</th> 
                                    <th>Price/Qnty</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>   
                            </thead>
                            <tbody>';
                while ($row = $result->fetch_assoc()) 
                {
                    echo '<tr>
                            <td><img src="' . $row['img'] . '"></td>
                            <td><p>' . $row['Product_brand'] .'</p>' . $row['Product_name'] .'</td>
                            <td>Rs ' . $row['discounted_price'] .'<span id="actual_price">' . $row["Price"] . '</span></td>
                            <td>
                            <form action="update_quantity.php?prod_id=' .  $row['prod_id'] . '" method="post" id="prod_qnty_update">
                                <input type="hidden" name="prod_id" value="' . $row['prod_id'] .'">
                                <input type="number" name="quantity" value="' .  $row['Qnty'] . '" min="1">
                                <button type="submit">Update</button>
                            </form>
                            </td>
                            <td>Rs ' . ($row['Qnty'] * $row['discounted_price']) .'</td>
                            <td><a href="cart_delete.php?prod_id=' . $row['prod_id'] .'"><i class="fa-solid fa-trash-can"></i></a></td>
                        </tr>';               
                }
                echo '</tbody>
                    </table>
                    <form action="checkout.php" method="post">
                        <button type="submit"> Proceed to checkout </button>
                    </form>
                </div>';
            }
            $stmt->close();
        } else {
            echo '<section id="login-message" class="section-p1">
                    <div>
                        <p>Please <a href="login_register.php">log in</a> to add items to your cart.</p>
                    </div>
                </section>';
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
                    <p><strong>Address:</strong> Christ University, Banglore</p>
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
</body>
</html>