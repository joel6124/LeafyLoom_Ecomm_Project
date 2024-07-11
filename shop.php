<?php
    include("connection.php");
    session_start();
    $cat="";
    if(isset($_GET['cat']))
    {
        $cat=$_GET['cat'];
    }
    if($cat=="all")
    {
        $sql="select * from products;";
        $result=$conn->query($sql);
    }
    else
    {
        $sql= "select * from products where Category_id='$cat';";
        $result=$conn->query($sql);
    }
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
                <li><a class="active" href="shop.php?cat=all">Shop</a></li>
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



    <section id="shop">
        <div class = "sidebar">
            <input type = "text" id = "text-search" placeholder = "Search Products"/>
            <h3> Categories </h3>
            <ul>
                <a href="shop.php?cat=all"><li>All</li></a>
                <a href="shop.php?cat=C1"><li>Gifts</li></a>
                <a href="shop.php?cat=C2"><li>Personal Care</li></a>
                <a href="shop.php?cat=C3"><li>Kitchen</li></a>
                <a href="shop.php?cat=C4"><li>Cleaning Supplies</li></a>
                <a href="shop.php?cat=C5"><li>Travel Supplies</li></a>
            </ul>
        </div>

        <div id="products" class="section-p1 shop-prod">
            <h2> Our Products </h2>
            <p> Discover our collection </p>
            <div class="prod-container">
            <?php
                while ($row = $result->fetch_assoc()) 
                {
                    echo '<a href="prod_details.php?id=' . $row['Product_id'] . '" class="prod" style="">
                            <img src="' . $row['Img1'] . '" alt="" width="150" height="225">
                            <div class="desc">
                                <span>' . $row['Product_brand'] . '</span>
                                <h5>' . $row['Product_name'] . '</h5>
                                <div class="leaf">';

                    for ($i = 0; $i < $row['Eco_rating']; $i++) {
                        echo '<i class="fa-solid fa-leaf" style="margin: 1px;"></i>';
                    }

                    echo '</div>
                            <h4>Rs ' . $row['discounted_price'] . '</h4>
                            <h6 style="text-decoration: line-through; font-size: 14px;">Rs ' . $row['Price'] . '</h6>
                        </div>
                        <div class="cart">
                                <form action="cart_update.php" method="post">
                                    <input type="hidden" name="prod_id" id="prod_id" value="' . $row['Product_id'] .'">
                                    <input type="hidden" id="qnty" name="qnty" value="1">
                                    <button type="submit" style="border: none; background-color: transparent;"><i class="fa-solid fa-cart-shopping"></i></button>
                                </form>
                        </div>            
                    </a>';
                }
            ?>

            </div>
        </div>
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
