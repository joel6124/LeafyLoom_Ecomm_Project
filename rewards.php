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

        .leaderboard_points {
            width: 100%;
            background-color: #e7e7e0;
            display: flex;
            justify-content: space-evenly;
            align-items: center; 
            padding: 20px;
        }

        .eco-warrior-leaderboard {
            width: 550px;
            background: rgb(19,42,19);
            background: linear-gradient(291deg, rgba(19,42,19,1) 47%, rgba(69,129,108,1) 100%);
            color: #e7e7e0;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .eco-warrior-leaderboard h2 {
            font-size: 20px;
            color: #90A955;
        }

        .eco-warrior-leaderboard p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
        }


        .part1
        {
            text-align: center;
            margin: 30px 30px;
        }
        .description h3
        {
            color: #4F772D;
            font-size: 20px;
            font-weight: bold;
        }
        .hashtag
        {
            text-align: center;
            margin-bottom: 15px;
        }
        .hashtag h2
        {
            color: #90A955;
            letter-spacing: 1px;
        }
        .part2 {
            position: relative; 
            border-radius: 10px;
            text-align: center;
            max-width: 5em;
            max-height: 520px;
            overflow: hidden;
            background-color: #132A13;
        }

        .search-bar 
        {
            background-color: #4F772D;
            position: sticky;
            top: 0;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            /* background-color: #132A13; */
            padding: 20px;
        }

        .search 
        {
            width: 60%;
            height: 20%;
            border-radius: 30px;
            border: 2px solid #e7e7e0;
            background-color: transparent;
            font-size: 1em;
            padding: 0.5em;
        }

        .search::placeholder {
            color: #d2d5dc;; 
            text-align: center;
        }

        .table {
            position: relative;
            margin-top: 2em;
            width: 40em;
            height: 380px;
            overflow: auto;
            max-height: 520px;
            border-radius: 10px;
            display: block;
            padding-right: 10px;
            background-color:#132A13;
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

        table thead 
        {
            position: sticky;
            top: 0;
            left: 0;
            background-color: #132A13;
        }

        table th 
        {
            padding-bottom: 10px;
            font-size: 18px;
            text-align: center;
            color: white;
        }

        tbody tr 
        {
            border-radius: 0px;
            box-shadow: 0 1.8px rgb(25, 53, 37);
        }


        tbody tr.even-row {
        background-color: #4F772D;
        }

        tbody tr.odd-row {
            background-color: #90A955;
        }

       
        #green-loyalty-program {
            background-color: #e7e7e0;
            color: #132A13;
            font-weight: bold;
            padding: 20px;
            text-align: center;
        }

        .loyalty-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }
        .glp
        {
            border-radius: 10px;
        }

        .green-loyalty-section
        {
            color:#e7e7e0;
            text-align: center;
            border-radius: 15px;
        }

        .green-loyalty-section h2
        {
            font-size: 30px;
            color: #4F772D;
        }
        #green-loyalty-program h2 
        {
            margin-top: 20px;
            color: #90A955;
        }

        .green-loyalty-section p,
        #green-loyalty-program p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .goal .img_goal
        {
            margin-top: 40px;
        }
        .goal
        {
            padding-top: 0px;
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
            background-color: #90A955;
        }

        /* Custom Scroll Styling */
        .table::-webkit-scrollbar {
            width: 8px;
        }

        .table::-webkit-scrollbar-thumb {
            background-color:#e7e7e0;
            border-radius: 10px;
        }

        .table::-webkit-scrollbar-track {
            background-color: #132A13;
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
            background-color: #132A13;
            padding: 10px;
            align-items: center;
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
                <li><a class="active"  href="rewards.php">Rewards</a></li>
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
    <div class="leaderboard_points">
        <div class="part1">
            <img src="img/earth_greenery (1).jpg" alt="reward" width="420" height="380">
            <div class="description">
                <div class="eco-warrior-leaderboard">
                    <h2>Where Every Choice Weaves a Greener Future!!</h2>
                    <p>Join the leaderboard and become an Eco Warrior! Every sustainable choice you make contributes to a greener future.</p>
                </div>
            </div>
        </div>

        <div class="hashtag_table">
            <div class="hashtag">
                <h2>#EcoWarriorLeaderboard</h2>
            </div>
            <div class="part2" style="max-width: 50em; margin-left: 20px; margin-right: auto; padding: 1em;">
                <div class="search-bar">
                    <input type="text" class="search" id="search" name="search" placeholder="Enter your name to see where you stand"  onkeyup="searchFun()">
                </div>
                <div class="table">
                    <table class="leaderboard_table">
                        <thead>
                            <tr>
                                <th>#Rank</th>
                                <th>Participant</th>
                                <th>Green Points</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $sql="SELECT customer.fname as f_name, rewards.Points as pts FROM rewards,customer WHERE customer.Customer_id=rewards.Customer_id  order by pts desc;";
                                $result=$conn->query($sql);
                                $conn->close();
                                $rank = 0;
                                while ($row = $result->fetch_assoc()) 
                                {
                                    $rank += 1;
                                    $row_class = $rank % 2 == 0 ? 'even-row' : 'odd-row';
                                    echo '<tr class="' . $row_class . '">
                                            <td>' . $rank . '</td>
                                            <td>' . $row['f_name'] . '</td>
                                            <td>' . $row['pts'] . '</td>
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
     
    <!-- Rewards Instructions Section -->
    <section id="green-loyalty-program">
        <div class="loyalty-content">
            <div class = "glp">
                <div class="green-loyalty-section">
                    <h2>Join Our Green Loyalty Program!</h2>
                    Make eco-friendly choices and earn rewards for a sustainable future.
                    <!-- Add a button or link for more information or sign-up -->
                </div>
                <div class="goal">
                    <div class="img_div_left">
                        <img src="img/code_icon.png" alt="goal11" class="img_goal">
                    </div>
                    <div class="content_right">
                        <p class="content_desc"><strong> 1 - Purchase and Unique Code Generation: </strong> After a customer makes a purchase on our e-commerce website, we will generate a secret, unique code associated with their order. This code will be provided to the customer along with their order confirmation email.</p>
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
                        <p class="content_desc"><strong> 3 - Verification Process: </strong> At the RVM, customers will deposit their recyclables and then receive a receipt (bill) from the machine. They will then take a photo of the receipt they received from the RVM.</p>
                    </div>
                </div>
        
                <div class="goal">
                    <div class="content_left">
                        <p class="content_desc"><strong> 4 - Upload and Submission: </strong> Customers will now upload the photo of the receipt and post the unique code provided to them after the order confirmation through the rewards section of our website.</p>
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
                        <p class="content_desc"><strong> 5 - Verification and Reward Provision: </strong> Upon receiving the photo submission and the unique code, we will verify the authenticity of the uploaded photo and ensure that the secret unique code matches the customer's order and that the receipt is legitimate. Once verified, customers will receive additional Eco Points for thier sustainable activities.</p>
                    </div>
                </div>
                <br>

                <div class="goal">
                    <div class="content_left">
                        <p class="content_desc"><strong> 6 - Redemption of Reward: </strong> Customers can then redeem their reward/Points during their next purchase from LeafyLoom, applying it at checkout.</p>
                    </div>
                    <div class="img_div_right">
                        <img src="img/redemption_icon.png" alt="goal15" class="img_goal">
                    </div>
                </div>
                <br>
                <br>
            </div>
        </section>
            
    <div class = "verification">
        <center>
            <form id="photo-form" action="upload_rvm_receipt.php" method="post" enctype="multipart/form-data">
                <label for="verification-code">Verification Code</label>
                <input type="text" id="verification-code" name="verification-code" required>

                <label for="rvm-rec">Upload RVM Receipt</label>
                <input type="file" id="rvm-rec" name="rvm-rec" accept="image/*" required>

                <input type="submit" value="Submit RVM Receipt">
            </form>
        </center>                
    </div>
    <!-- Photo Submission Form -->
    

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
        function searchFun() 
        {
            let filter = document.querySelector("#search").value.toLowerCase();
            let table = document.querySelector(".leaderboard_table");
            let tr = table.getElementsByTagName('tr');
            let found = false;
            let noRecordsRow = document.querySelector("#noRecordsRow");

            if (noRecordsRow) 
            {
                noRecordsRow.remove();
            }

            for (var i = 0; i < tr.length; i++) 
            {
                let td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    let txtval = td.textContent || td.innerHTML;
                    if (txtval.toLowerCase().indexOf(filter) > -1) 
                    {
                        tr[i].style.display = "";
                        found = true;
                    } 
                    else 
                    {
                        tr[i].style.display = "none";
                    }
                }
            }

            if (!found && !noRecordsRow) 
            {
                noRecordsRow = document.createElement('tr');
                noRecordsRow.setAttribute('id', 'noRecordsRow');
                let noRecordsCell = document.createElement('td');
                noRecordsCell.setAttribute('colspan', '3');
                noRecordsCell.textContent = 'No records found.';
                noRecordsRow.appendChild(noRecordsCell);
                table.appendChild(noRecordsRow);
            }
        }
    </script>

    
</body>
</html>