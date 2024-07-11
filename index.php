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
    <link rel="shortcut icon" href="img/logo-icon.png" type="image/x-icon">
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

    <section id="home">
        <div id="cover_pg">
            <h4>Join Our Eco-Revolution!</h4>
            <h2 >Where Every Choice Weaves a Greener Future!</h2>
            <h1>Shop Responsibly... Shop Sustainably...</h1>
            <!-- <img src="img/bio.png" alt="bio" width="300"> -->
            <p id="cover-desc">Snap Your RVM Receipt, Score Big! Sign up for our leaderboard and showcase your sustainable journey.</p>
            <p id="cover-desc">Earn bonus points for every recycled receipt!</p>
            <button class="home-btn" onclick="window.location.href='shop.php?cat=all'">Shop Now</button>

        </div>
    </section>
    
    <section id="banner" class="section-m1">
        <h3>Join our innovative <span>Green Loyalty Program</span> and be part of a groundbreaking movement!</h4>
        <h5>Share photos of your RVM receipts and unlock not just rewards but also contribute to our collective mission for a greener planet. Together, let's fuel positive change—one receipt at a time.</h5>
        <button class="banner_btn" onclick="window.location.href='rewards.php'">Upload Receipts & Earn Points</button>
    </section>

    <section id="products" class="section-p1">
        <h2>Featured Products</h2>
        <p class="subtitle">Try these at our best offers!</p>
        <div class="prod-container">
            <?php 
                $sql_products = "SELECT product_id, SUM(quantity) AS total_ordered
                FROM order_details
                GROUP BY product_id
                ORDER BY total_ordered DESC
                LIMIT 5";

                $stmt_prod = $conn->prepare($sql_products);
                $stmt_prod->execute();
                $result_prod = $stmt_prod->get_result();
                $stmt_prod->close();
                            
                while ($prod = $result_prod->fetch_assoc()) {
                    $sql_prod_dt = 'SELECT * FROM products WHERE Product_id=?';
                    $stmt_prod_dt = $conn->prepare($sql_prod_dt);
                    $stmt_prod_dt->bind_param("s", $prod['product_id']);
                    $stmt_prod_dt->execute();
                    $result_prod_dt = $stmt_prod_dt->get_result();
                    $stmt_prod_dt->close();
                    
                    while ($row = $result_prod_dt->fetch_assoc()) {
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
                }
            ?>

        </div>

    </section>

    <section id="aboutus">
        <h2>About Us</h2>
        <p class="subtitle">What's LeafyLoom about?</p>
        <div class="about">
            <div class="abt-img">
                <img src="img/mission_icon.png" alt="" height="400px">
            </div>
            <div class="abt-content">
                <h1>Our Mission</h1>
            <p>At LeafyLoom, we are on a mission to cultivate a greener future by offering a thoughtfully curated selection of eco-friendly products that inspire sustainable living. Rooted in our commitment to environmental stewardship, we strive to empower individuals to make conscious choices that benefit both themselves and the planet. Through the fusion of innovation, style, and sustainability, we aim to weave a tapestry of positive change, fostering a community dedicated to reducing our ecological footprint. 
                </p>
            <p>Join us on this journey towards a healthier, happier Earth, where every purchase with LeafyLoom is a step towards a more sustainable tomorrow.</p>
            </div>
        </div>

        <div class="features-section">	
            <ul class="feature-squares">
                <li>
                    <img src="img/rvm.jpg" alt="feature icon" width="80px" height="80px">
                    <div class="text">
                        <h3>Green Loyalty Program</h3>
                        <p>Elevate your rewards journey with our innovative RVM Rewards Program. Upload photos of your RVM receipts, earn extra points, and be a part of a community dedicated to rewarding sustainable actions.</p>
                    </div>
                </li>
                <li>
                    <img src="img/leaderboard.gif" alt="feature icon" width="80px" height="80px">
                    <div class="text">
                        <h3>Sustainability Leaderboard</h3>
                        <p>Fuel your eco-friendly journey with friendly competition. Our Sustainability Leaderboard tracks and celebrates your efforts. Compete with others and lead the way towards a greener world.</p>
                    </div>
                </li>
                <li>  
                    <img src="img/about_blog.jpg" alt="feature icon" width="80px">
                    <div class="text">
                        <h3>Community Blog Section</h3>
                        <p>Share your experiences, tips, and inspirations in our vibrant Community Blog. LeafyLoom connects you with fellow sustainability enthusiasts, empowering collective impact.</p>
                    </div>
                </li>
                <li>
                    <img src="img/about_reward.jpg" alt="feature icon" width="80px">
                    <div class="text">
                        <h3>Exciting Discounts</h3>
                        <p>Unlock exclusive discounts with every purchase and receive special rewards when you upload your RVM receipts. LeafyLoom recognizes your dedication to sustainability and appreciates your efforts to create a positive impact.</p>
                    </div>
                </li>
                <!-- <div class="clear"></div>	 -->
            </ul>
        </div>


        <div class="team-section"><a name="about"></a>
            <h2>Our Team</h2>
            <p class="subtitle">Get to know us</p>
            <ul class="team-list">
                <li>
                    <div class="image-container">
                        <img src="img/aimee.jpg" alt="team member" >
                    </div>
                    <h5>Aimee Susan</h5>
                    <p>~ 2241005</p>
                    <ul class="social-links">
                        <li><a href="#" class="facebook">Facebook</a></li>
                        <li><a href="#" class="twitter">Twitter</a></li>
                        <li><a href="#" class="google">Google+</a></li>
                    </ul>
                </li>
                <li>
                    <div class="image-container">
                        <img src="img/joel.jpg" alt="team member" >
                    </div>
                    <h5>Joel Jino</h5>
                    <p>~ 2241024</p>
                    <ul class="social-links">
                        <li><a href="#" class="facebook">Facebook</a></li>
                        <li><a href="#" class="twitter">Twitter</a></li>
                        <li><a href="#" class="google">Google+</a></li>
                    </ul>
                </li>
                <li>
                    <div class="image-container">
                        <img src="img/navneet.jpg" alt="team member" >
                    </div>
                    <h5>Navneet Joshi</h5>
                    <p>~ 2241037</p>
                    <ul class="social-links">
                        <li><a href="#" class="facebook">Facebook</a></li>
                        <li><a href="#" class="twitter">Twitter</a></li>
                        <li><a href="#" class="google">Google+</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </section>
    
    <section id="SDG">
        <h2 style="display:inline-flex;">Our Goals</h2>

        <div class="goal">
            <div class="img_div_left">
                <img src="img/goal11.png" alt="goal11" class="img_goal">
            </div>
            <div class="content_right">
                <p class="content_desc">LeafyLoom, where your sustainable journey begins! By choosing eco-friendly products from our platform, you contribute to Goal 11: Sustainable Cities and Communities. Every purchase fosters a cleaner, greener urban environment, promoting responsible consumption and a healthier city life.</p>
            </div>
        </div>

        <div class="goal">
            <div class="content_left">
                <p class="content_desc">We believe in mindful choices. Our curated collection of eco-friendly wares aligns with Goal 12: Responsible Consumption and Production. Each product is a step towards reducing waste, promoting ethical sourcing, and embracing a circular economy. Join us in making every purchase count for a sustainable future.</p>
            </div>
            <div class="img_div_right">
                <img src="img/goal12.png" alt="goal12" class="img_goal">
            </div>
        </div>

        <div class="goal">
            <div class="img_div_left">
                <img src="img/goal13.png" alt="goal13" class="img_goal">
            </div>
            <div class="content_right">
                <p class="content_desc">LeafyLoom is your ally in the fight against climate change! By opting for our eco-friendly alternatives, you directly contribute to Goal 13: Climate Action. Embrace a sustainable lifestyle, reduce your carbon footprint, and join the movement to protect our planet. Every small action counts, and together, we can make a significant impact.</p>
            </div>
        </div>

        <div class="goal">
            <div class="content_left">
                <p class="content_desc">We are committed to nurturing life on land and support Goal 15 by promoting sustainable practices that protect and restore ecosystems. With each purchase, you help us in preserving biodiversity, promoting responsible forestry, and ensuring a greener, healthier planet for generations to come.</p>
            </div>
            <div class="img_div_right">
                <img src="img/goal15.png" alt="goal15" class="img_goal">
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
    <script src="script.js">
    </script>
</body>
</html>