<?php
    include("connection.php");
    session_start();

    $cus_id=$_SESSION['cust_id'];
    $sql="SELECT fname, lname, Email_address, Contact, Address from customer WHERE Customer_id=?";
    $stmt_fetch_profile=$conn->prepare($sql);
    $stmt_fetch_profile->bind_param("s",$cus_id);
    $stmt_fetch_profile->execute();
    $result = $stmt_fetch_profile->get_result();
    $stmt_fetch_profile->close();
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>

        .profile-body
        {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px 130px 20px 50px;
        }
        .profile
        {
            width: 50%;
            padding: 40px 30px;
        }

        .form-box h2 
        {
            text-align: center;
        }

        .input-box 
        {
            display: flex;
            position: relative;
            width: 100%;
            height: 50px;
            margin: 50px 0;
        }

        .input-box label 
        {
            position: absolute;
            left: 35px;
            top: -8px;
            font-size: 1em;
            color: #31572c;
            font-weight: 600;
        }

        .input-box input 
        {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            font-size: 1em;
            color: #132A13;
            font-weight: bold;
            margin: 20px 25px;
            padding: 0 5px;
        }
        .input-box textarea
        {
            width: 89%;
            height: 100%;
            border-bottom: 2px solid #132A13;
            outline: none;
            font-size: 1em;
            color: #132A13;
            font-weight: bold;
            margin: 20px 25px;
            padding: 0 5px;
        }

        .input-box .icon 
        {
            position: relative;
            right: 55px;
            top: 14px;
            font-size: 1.2em;
            color: #132A13;
            line-height: 57px;
        }

        .btn 
        {
            width: 100%;
            height: 45px;
            background-color: #132A13;
            border: none;
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            color: #fff;
            font-weight: bold;
        }

        .login-profile 
        {
            font-size: .9em;
            text-align: center;
            font-weight: 500;
            margin: 25px 0 10px;
        }

        .login-profile p a 
        {
            color: #132A13;
            text-decoration: none;
            font-weight: 600;
            padding: 5px;
        }

        .login-profile p a:hover {
            text-decoration: underline;
        }

        .profile-btn
        {
            margin: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;

        }
        .edit-btn,
        .save-btn {
            background-color: #132A13;
            color: #d2d5dc;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover,
        .save-btn:hover {
            background-color: #31572c;
        }

        .points-container 
        {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #90A955;
            color: #132A13;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 280px;
            height: 380px;
            text-align: center;
        }
        .points-container span
        {
            color: #132A13;
            font-size: 19px;
            font-weight: bold;
        }
        .points-container img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin: 10px;
        }

        .points-container h3 
        {
            margin-bottom: 5px;
        }

        .points-container button {
            background-color: #132A13;
            color: #d2d5dc;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .input-box input:read-only,
        .input-box textarea:read-only 
        {
            opacity: 0.5;
            pointer-events: none;
            background-color: #f4f4f4;
        }
    


        .points-container button:hover {
            background-color: #31572c;
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
                <li><a class="active" href="<?php echo isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true ? '#' : 'login_profile.php'; ?>" id="user_pf"><i class="fa-solid fa-user"></i>
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


   <div class="profile-body">
    <div class="profile">
                <h2>My Profile</h2>
                <form onsubmit="return validateProfileforUpdate()" action="update_profile.php" method="post">
                    <div class="input-profile">
                        <div class="input-box">
                            <label>First Name</label>
                            <input id="fname" name="fname" type="text" value="<?php echo $row['fname']; ?>" readonly required>
                            <span class="icon"><i class="fa-regular fa-id-card"></i></span>

                            <label style="margin-left: 50%;">Last Name</label>
                            <input id="lname" name="lname" type="text" value="<?php echo $row['lname']; ?>" readonly required>
                            <span class="icon"><i class="fa-regular fa-id-card"></i></span>
                            
                            
                        </div>
                        <div class="input-box">
                            <label>Email</label>
                            <input id="e-id" name="e-id" type="email" value="<?php echo $row['Email_address']; ?>" readonly required>
                            <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        </div>
                        <div class="input-box">
                            <label>Mobile Number</label>
                            <input id="ph_no" name="ph_no" type="number" value="<?php echo $row['Contact']; ?>" readonly required>
                            <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        </div>
                        <div class="input-box">
                            <textarea id="address" name="address" rows="4" cols="50" readonly required><?php echo $row['Address']; ?></textarea>
                            <label>Address</label>
                        </div>
                    </div>
                    <div class="profile-btn">
                        <button class="edit-btn" onclick="enable_edit(); return false;">Edit</button>
                        <button class="save-btn" type="submit">Save</button>
                    </div>
                </form>
        </div>
        <?php
            $sql_fetch_rewards="SELECT Points FROM rewards WHERE Customer_id=?";
            $stmt_rew=$conn->prepare($sql_fetch_rewards);
            $stmt_rew->bind_param("s",$cus_id);
            $stmt_rew->execute();
            $result = $stmt_rew->get_result();
            $row = $result->fetch_assoc();
            $stmt_rew->close();
        ?>
        <div class="points-container">
            <img src="img/rvm.jpg" alt="Eco Icon">
            <h3>Join Our Green Loyalty Program!</h3>
            <p>You currently have</p>
            <span><?php echo $row['Points']; ?> Eco Points</span>
            <p>Keep earning more!"</p>
            <button onclick="window.location.href='rewards.php'"><strong>Get More!</strong></button>
        </div>
   </div>
        

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
        function validateProfileforUpdate() 
        {
            var ph_no = document.querySelector('#ph_no').value;
            if (!(/^\d{10}$/.test(ph_no))) 
            {
                alert('Invalid Phone Number Entered!');
                return false;
            }
            if(!confirm('Confirm Profile Details?'))
            {
                return false;
            }
            return true;

        }

        function enable_edit() 
        {
            var inputs = document.querySelectorAll('input');
            var textarea = document.querySelector('textarea');
            inputs.forEach(function (input) {
                input.readOnly = false;
            });
            textarea.readOnly = false;
        }

    </script>
</body>
</html>
