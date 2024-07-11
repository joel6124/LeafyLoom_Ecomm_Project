<?php
    include("connection.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>

        .pay_container 
        {
            width: 600px;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1),
                        0 5px 12px -2px rgba(0, 0, 0, 0.1),
                        0 18px 36px -6px rgba(0, 0, 0, 0.1);
        }

        .pay_container .pay_title {
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .pay_container form input {
            display: none;
        }

        .pay_container form .category {
            margin-top: 10px;
            padding-top: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 15px;
        }

        .category label {
            height: 145px;
            padding: 20px;
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 5px;
            position: relative;
        }

        #visa:checked ~ .category .visaMethod,
        #mastercard:checked ~ .category .mastercardMethod,
        #paypal:checked ~ .category .paypalMethod,
        #AMEX:checked ~ .category .amexMethod {
            box-shadow: 0px 0px 0px 1px #90A955;
        }

        #visa:checked ~ .category .visaMethod .check,
        #mastercard:checked ~ .category .mastercardMethod .check,
        #paypal:checked ~ .category .paypalMethod .check,
        #AMEX:checked ~ .category .amexMethod .check {
            display: block;
        }

        .imgName {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: column;
            gap: 10px;
        }

        .imgName span {
            font-family: Arial, Helvetica, sans-serif;
            position: absolute;
            top: 72%;
            transform: translateY(-72%);
        }

        .imgName .imgContainer {
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 35%;
            transform: translateY(-35%);
        }

        .payment_img {
            width: 50px;
            height: auto;
        }

        .visa img {
            width: 80px;
        }

        .mastercard img {
            width: 65px;
        }

        .paypal img {
            width: 80px;
        }

        .AMEX img {
            width: 50px;
        }

        .check {
            display: none;
            position: absolute;
            top: -4px;
            right: -4px;
        }

        .check i {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="LeafyLoom" width="120" height="120"></a>
        <!-- <a id="logo" href="home.html">LeafyLoom</a> -->
        <div id="navbar">
            <ul id="navbar" class="center-nav">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="#aboutus">About</a></li>
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
    <div class="pay_container">
        <div class="pay_title">
            <h4 style="color: #31572c">Select a <span style="color: #90A955">Payment</span> method</h4>
        </div>

        <form action="#">
            <input type="radio" name="payment" id="mastercard">
            <input type="radio" name="payment" id="paypal">
            <input type="radio" name="payment" id="AMEX">

            <div class="category">
                <label for="mastercard" class="mastercardMethod">
                    <div class="imgName">
                        <div class="imgContainer mastercard">
                            <img class="payment_img" src="https://i.ibb.co/vdbBkgT/mastercard.jpg" alt="">
                        </div>
                        <span class="name">UPI</span>
                    </div>
                    <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                </label>

                <label for="paypal" class="paypalMethod">
                    <div class="imgName">
                        <div class="imgContainer paypal">
                            <img class="payment_img" src="https://i.ibb.co/KVF3mr1/paypal.png" alt="">
                        </div>
                        <span class="name">Credit/Debit Card</span>
                    </div>
                    <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                </label>

                <label for="AMEX" class="amexMethod">
                    <div class="imgName">
                        <div class="imgContainer AMEX">
                            <img class="payment_img" src="https://i.ibb.co/wQnrX86/American-Express.jpg" alt="">
                        </div>
                        <span class="name">Cash On Delivery</span>
                    </div>
                    <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                </label>
            </div>
        </form>
    </div>
</body>
</html>
