<?php
    include("connection.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .leaderboard_points 
        {
            width: 100%;
            background-color: #e7e7e0;
            display: flex;
            justify-content: space-evenly;
            align-items: center; 
            padding: 20px;
        }

        .part1 
        {
            text-align: center;
            margin: 30px 80px;
        }

        .part2 
        {
            border: 3px solid #132A13;
            border-radius: 10px;
            text-align: center;
            background-color: #90A955;
            max-width: 5em;
            max-height: 520px;
            overflow: hidden;
        }

        .search-bar 
        {
            position: sticky;
            top: 0;
            background-color: ##90A955;
            padding: 10px;
        }

        .search 
        {
            width: 60%;
            height: 20%;
            border-radius: 30px;
            border: 2px solid rgb(25, 53, 37);
            background-color: transparent;
            font-size: 1em;
            padding: 0.5em;
        }
        .search::placeholder {
            color: #e7e7e0; 
            text-align: center;
        }

        .table {
            position: relative;
            margin-top: 2em;
            width: 40em;
            height: 80%;
            overflow: auto;
            max-height: 520px;
            border-radius: 10px;
            display: block;
            padding-right: 10px;
            color: #;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            text-align: center;
            padding: 1em;
            font-size: 17px;
            color: white;
        }

        table thead {
            position: sticky;
            top: 0;
            left: 0;
            background-color: #4F772D;
        }

        table th {
            font-size: 18px;
            color: rgb(25, 53, 37);
        }

        tbody tr {
            border-radius: 0px;
            box-shadow: 0 1.8px rgb(25, 53, 37);
        }

        #first td,
        #second td,
        #third td {
            font-weight: 800;
        }

        #first td {
            color: #dbba00;
        }

        #second td {
            color: #c1c0c0;
        }

        #third td {
            color: #814514;
        }

        .green-loyalty-section,
        #green-loyalty-program {
            background-color: #e7e7e0;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .loyalty-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }

        .green-loyalty-section h2,
        #green-loyalty-program h2 {
            font-size: 30px;
            color: #90A955;
        }

        .green-loyalty-section p,
        #green-loyalty-program p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        #photo-form {
            margin-top: 20px;
        }
        #photo-form label {
            display: block;
            margin-bottom: 15px;
            color: #ffffff;
        }

        #photo-form input[type="text"],
        #photo-form input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ffffff;
        }

        #photo-form input[type="submit"] {
            background-color: #4e894e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #photo-form input[type="submit"]:hover {
            background-color: #2a472a;
        }

        /* Custom Scroll Styling */
        .table::-webkit-scrollbar {
            width: 10px;
        }

        .table::-webkit-scrollbar-thumb {
            background-color:rgb(25, 53, 37);
            border-radius: 10px;
        }

        .table::-webkit-scrollbar-track {
            background-color: ##90A955;
        }

        /* Media Query for responsiveness */
        @media (max-width: 768px) {
            .leaderboard {
                flex-direction: column;
            }

            .part2 {
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            .table {
                width: 100%;
                max-width: none;
            }
        }

        .glp{
            background-color: #132A13;
            padding: 10px;
        }

        .verification{
            background-color: #31572C;
            padding: 10px;
            align-items: center;
        }
    </style>
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
                <li><a class="active" href="rewards.php">Rewards</a></li>
                <li><a href="index.php#footer">Contact Us</a></li>
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
                                <a href="logout.php" class="sub-menu-link"><i class="fa-solid fa-right-from-bracket"></i><p>Logout</p><i class="fa-solid fa-caret-right"></i></a>
                                <a href="profile.php" class="sub-menu-link"><i class="fa-solid fa-user"></i><p>Profile</p><i class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>';
                }
            ?>

        </div>

    </section>
    <div class="leaderboard_points">
        <div class="part1">
            <img src="img/earth_greenery (1).jpg" alt="reward" width="540" height="500">
            <h3>Every Choice Weaves a Greener Future!!</h3>
        </div>
        <div class="part2" style="max-width: 50em; margin-left: 20px; margin-right: auto; padding: 1em;">
            <div class="search-bar">
                <input type="search" class="search" id="search" placeholder="Enter your name to see where you stand">
            </div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Participant</th>
                            <th>Green Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="first">
                            <td>1</td>
                            <td>John</td>
                            <td>367</td>
                        </tr>
                        <tr id="second">
                            <td>2</td>
                            <td>Jerrin</td>
                            <td>325</td>
                        </tr>
                        <tr id="third">
                            <td>3</td>
                            <td>Willaim</td>
                            <td>227</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Rohan</td>
                            <td>189</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Martin</td>
                            <td>155</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Rohan</td>
                            <td>189</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Martin</td>
                            <td>155</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Rohan</td>
                            <td>189</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Martin</td>
                            <td>155</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
     <!-- Green Loyalty Program Section -->
     <div class="green-loyalty-section">
        <h2>Join Our Green Loyalty Program!</h2>
        Make eco-friendly choices and earn rewards for a sustainable future.
        <!-- Add a button or link for more information or sign-up -->
    </div>
    <!-- Rewards Instructions Section -->
    <section id="green-loyalty-program">
        <div class="loyalty-content">
            <center> <h2>Green Loyalty Program</h2><br> </center>
            <div class = "glp">
                <div class="goal">
                    <div class="img_div_left">
                        <img src="img/code_icon.png" alt="goal11" class="img_goal">
                    </div>
                    <div class="content_right">
                        <p class="content_desc"><strong> 1 - Purchase and Unique Code Generation: </strong> After a customer makes a purchase on our e-commerce website, we will generate a secret, unique code associated with their order. This code will be provided to the customer along with their order confirmation email or printed on their invoice.</p>
                    </div>
                </div>
        
                <div class="goal">
                    <div class="content_left">
                        <p class="content_desc"><strong> 2 - Recyclable Material Deposit: </strong> Customers will be instructed to visit the nearest Reverse Vending Machine (RVM) location to deposit recyclable materials, such as plastic bottles and aluminum cans.</p>
                    </div>
                    <div class="img_div_right">
                        <img src="img/rvm_icon.png" alt="goal12" class="img_goal">
                    </div>
                </div>
        
                <div class="goal">
                    <div class="img_div_left">
                        <img src="img/verification_process_icon.png" alt="goal13" class="img_goal">
                    </div>
                    <div class="content_right">
                        <p class="content_desc"><strong> 3 - Verification Process: </strong> At the RVM, customers will deposit their recyclables and then receive a receipt (bill) from the machine. They will then take a photo of the receipt along with the unique verification code provided by our website. Both the receipt and the verification code should be clearly visible in the photo.</p>
                    </div>
                </div>
        
                <div class="goal">
                    <div class="content_left">
                        <p class="content_desc"><strong> 4 - Upload and Submission: </strong> Customers will upload the photo of the receipt containing the unique code to our e-commerce website through a designated portal.</p>
                    </div>
                    <div class="img_div_right">
                        <img src="img/submission_icon.png" alt="goal15" class="img_goal">
                    </div>
                </div>

                <div class="goal">
                    <div class="img_div_left">
                        <img src="img/reward_provision_icon.png" alt="goal13" class="img_goal">
                    </div>
                    <div class="content_right">
                        <p class="content_desc"><strong> 5 - Verification and Reward Provision: </strong> Upon receiving the photo submission, our website's backend system will verify the authenticity of the uploaded photo, ensuring that the secret unique code matches the customer's order and that the receipt is legitimate. Once verified, customers will receive a discount code or voucher via email or within their account on our website.</p>
                    </div>
                </div>
                <br>

                <div class="goal">
                    <div class="content_left">
                        <p class="content_desc"><strong> 6 - Redemption of Reward: </strong> Customers can then redeem their reward or discount during their next purchase on our e-commerce website, applying it at checkout.</p>
                    </div>
                    <div class="img_div_right">
                        <img src="img/redemption_icon.png" alt="goal15" class="img_goal">
                    </div>
                </div>
                <br>
                <br>
            </section>
            </div>
            
            <div class = "verification">
                <center>
                    <form id="photo-form" action="upload.php" method="post" enctype="multipart/form-data">
                        <label for="verification-code">Verification Code:</label>
                        <input type="text" id="verification-code" name="verification-code" required>
        
                        <label for="tree-photo">Upload Tree Photo:</label>
                        <input type="file" id="tree-photo" name="tree-photo" accept="image/*" required>
        
                        <input type="submit" value="Submit Photo">
                    </form>
                </center>                
            </div>
            <!-- Photo Submission Form -->
            
        </div>
    </section>


    
</body>
</html>