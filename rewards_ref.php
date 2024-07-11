<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .leaderboard_points {
            background-color: #e7e7e0;
        }

        .leaderboard {
            display: flex;
            justify-content: space-evenly;
            padding: 30px;
        }

        .part2 {
            position: relative;
            border-radius: 30px;
            text-align: center;
            background-color: #132a13;
            max-width: 55em;
            max-height: 520px;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
        }

        .search-bar {
            position: sticky;
            top: 0;
            background-color: #132a13;
            padding: 10px;
        }

        .search {
            width: 60%;
            height: 20%;
            border-radius: 30px;
            border: 2px solid white;
            background-color: transparent;
            font-size: 1em;
            padding: 0.5em;
            color: white;
        }

        .table {
            position: relative;
            margin-top: 2em;
            width: 45em;
            height: 80%;
            overflow: auto;
            max-height: 520px;
            border-radius: 10px;
            display: block;
            padding-right: 10px;
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
            background-color: #132a13;
        }

        table th {
            font-size: 18px;
            color: white;
        }

        tbody tr {
            border-radius: 10px;
            box-shadow: 0 1.8px white;
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
            background-color: #31572C;
            color: white;
            padding: 50px;
            text-align: center;
        }

        .loyalty-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }

        .green-loyalty-section h2,
        #green-loyalty-program h2 {
            font-size: 32px;
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
            margin-bottom: 10px;
            color: #333;
        }

        #photo-form input[type="text"],
        #photo-form input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #photo-form input[type="submit"] {
            background-color: #3a5f3a;
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
            background-color: #6b6b6b;
            border-radius: 10px;
        }

        .table::-webkit-scrollbar-track {
            background-color: #132a13;
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
    </style>
    </style>
    
</head>
<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="LeafyLoom" width="120" height="120"></a>
        <!-- <a id="logo" href="home.html">LeafyLoom</a> -->
        <div>
            <ul id="navbar">
                <li><a   class="active" href="index.php">Home</a></li>
                <li><a href="index.php#aboutus">About</a></li>
                <li><a href="shop.php?cat=all">Shop</a></li>
                <li><a href="community_wareness.php">Community & Awareness</a></li>
                <li><a href="rewards.php">Rewards</a></li>
                <li><a href="#footer">Contact Us</a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="login_register.php"  id="user_pf"><i class="fa-solid fa-user"></i>
                <?php
                    if(isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true)
                    {
                        echo "<h5>Hello, <br>" . $_SESSION['username'] . "</h5>";
                    }
                    else
                    {
                        echo "<h5>Sign In</h5>";
                    }
                ?>
                </a></li>
            </ul>
        </div>

    </section>
    <div class="leaderboard_points">
        <div class="leaderboard">
            <div class="part1">
                <img src="img/rewards.jpg" alt="reward" width="500" height="500">
                <div class="description">
                    <h3>Every Choice Weaves a Greener Future!!</h3>
                </div>
            </div>
            <div class="part2" style="max-width: 55em; margin-left: auto; margin-right: auto; padding: 1em;">
                <div class="search-bar">
                    <input type="search" class="search" id="search" placeholder="Enter your name to see where you stand">
                </div>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>#Rank</th>
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
    </div>
     <!-- Green Loyalty Program Section -->
     <div class="green-loyalty-section">
        <h2>Join Our Green Loyalty Program!</h2>
        <p>Make eco-friendly choices and earn rewards for a sustainable future.</p>
        <!-- Add a button or link for more information or sign-up -->
        <a href="#instructions" class="button">Learn How to Participate</a>
    </div>

    <!-- Rewards Instructions Section -->
    <section id="green-loyalty-program">
        <div class="loyalty-content">
            <h2>Green Loyalty Program</h2>
            <p><strong>Verification Code Issuance:</strong> Upon successful delivery of the purchased items, customers will be provided with a unique 5-digit verification code.</p>
            <p><strong>Green Initiative:</strong> To avail of the discount or cashback, customers are encouraged to participate in our eco-friendly initiative. Grow a tree and capture a photo with both the verification code and the tree.</p>
            <p><strong>Photo Submission:</strong> Upload the photo, showcasing the verification code along with the newly grown tree, to our secure platform for verification.</p>
            <p><strong>Code and Tree Verification:</strong> Our dedicated team will carefully review the submitted photos, ensuring that both the 5-digit verification code and the tree are clearly visible.</p>
            <p><strong>Reward Issuance:</strong> Once the verification process is successfully completed, customers will be eligible to receive exclusive discounts or cashback on their next purchase as a token of appreciation for their commitment to environmental sustainability.</p>
            
            <!-- Photo Submission Form -->
            <form id="photo-form" action="upload.php" method="post" enctype="multipart/form-data">
                <label for="verification-code">Verification Code:</label>
                <input type="text" id="verification-code" name="verification-code" required>

                <label for="tree-photo">Upload Tree Photo:</label>
                <input type="file" id="tree-photo" name="tree-photo" accept="image/*" required>

                <input type="submit" value="Submit Photo">
            </form>
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
                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quidem </p>
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
    
</body>
</html>