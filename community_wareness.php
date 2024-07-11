<?php
    include("connection.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
                <li><a class="active" href="community_wareness.php">Community & Awareness</a></li>
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

    <div class="head_banner">
        <h1 class="heading">Welcome to the <span><span class="no-fill">LeafyLoom</span> Blog!</span></h1>
        <br>
        <a href="write_blog.php" class="blog_btn" target="_blank">Write a Blog</a>
    </div>

    

    <div class="blog-section" id="blogSection">
        <?php
            $sql = "select * from blog;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) 
            {
                echo '<div class="blog-card"> <img src="' . $row['Blog_pic'] . '" class="blog-img" alt="">
                    <p class="date_of_publish">' . $row['Blog_date'] . '</p>
                    <h1 class="blog-title">' . $row['Blog_title'] . '</h1>
                    <p class="blog-desc">' . $row['Blog_content'] . '</p>
                    <a href="" class="blog_btn read">Read</a> </div>';
            }
        ?>
    </div>
   


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
    <script src="blog.js"></script>
    <script src="script.js"></script>
</body>
</html>