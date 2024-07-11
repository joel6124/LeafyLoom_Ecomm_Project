<?php
    include("connection.php");
    session_start();
    $id="";
    if(isset($_GET["id"]))
    {
        $id=$_GET["id"];
    }
    $sql="select * from products where Product_id='$id';";
    $result=$conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <style>
        .sidebar
        {
            width: 40%;
        }
        .left, .right 
        {
            width: 50%;
            padding: 30px;
        }
        
        .flex {
            display: flex;
            justify-content: space-around;
        }
        
        /* .flex1 
        {
            display: flex;
        } */
        
        .main_image {
            width: auto;
            height: auto;
        }
        
        .option img {
            width: 75px;
            height: 75px;
            padding: 10px;
        }
        .left {
            margin: 80px;
        }
        
        .right {
            padding: 50px 100px 50px 50px;
        }
        
        .prod_desc_name 
        {
            color:#132A13;
            font-size: 25px;
            font-weight: bolder;
            display: block;
        }
        

        .prod_desc_h4,
        small {
            color:#4f772d;
            padding-top: 20px;
        }
        #actual_price
        {
            text-decoration: line-through; 
            color: #1b1b1b;
            font-size: 16px;
            padding-left: 5px;
        }
        
        .prod_desc_h5 {
            color:#132A13;
            font-weight: bolder;
            display: block;
            font-size: 18px;
            padding-bottom: 5px;
        }
        .prod_desc_h3
        {
            color:#132A13;
            font-size: 17px;
            margin: 20px 0 2px 0;
            font-weight: bolder;
            display: block;
            color:#4f772d;
        }
        .prod_desc_p {
            margin: 20px 0 25px 0;
            line-height: 25px;
            text-align: justify;
        }
        
        #qnty
        {
            height: 40px;
            width: 50px;
            font-size: 16px;
            text-align: center;
        }
        
        /* label,
        .add span
        {
            width: 25px;
            height: 25px;
            background: #000;
            border-radius: 50%;
            margin: 20px 10px 20px 0;
        } */
        
        /* .add label,
        .add span {
            background: none;
            border: 1px solid #132A13;
            color:#132A13;
            text-align: center;
            line-height: 25px;
        }
        
        .add label {
            padding: 10px 30px 0 20px;
            border-radius: 50px;
            line-height: 0;
        } */
        
        button {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
            background:#132A13;
            color: white;
            margin-top: 10%;
            border-radius: 30px;
        }

        .reviews
        {
            border-top: 3px solid #4f772d;
            padding-top: 20px; 
            margin-top: 80px;
        }
        .review
        {
            border-bottom: 1.5px solid #4f772d; 
            padding-bottom: 10px; 
            margin-bottom: 15px;
        }
        .review-text
        {
            font-size: 18px;
        }
        .rating-text
        {
            font-size: 16px;
            color: #ebb512;
        }
        .review-customer
        {
            font-size: 16px;
            text-align: right;
        }
        .star
        {
            font-size: 13px;
            color: #ebb512;
        }
        .star i
        {
            margin: 2px;
        }
        .star-rating
        {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }
        #ratingDisplay
        {
            padding-top: 33px;
            font-size: 16px;
            width: 128px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .star-rating button
        {
            width: 50px;
        }
        


        @media only screen and (max-width:768px) 
        {
            .container 
            {
            max-width: 90%;
            margin: auto;
            height: auto;
            }
        
            .left, .right {
            width: 100%;
            }
        
            .container {
            flex-direction: column;
            }
        }
        
        @media only screen and (max-width:511px) {
            .container {
            max-width: 100%;
            height: auto;
            padding: 10px;
            }
        
            .left, .right {
            padding: 0;
            }
        
            img {
            width: 100%;
            height: 100%;
            }
        
            .option {
            display: flex;
            flex-wrap: wrap;
            }


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

        <div class="container flex">
            <?php
                if($result->num_rows > 0)
                {
                    while($row=$result->fetch_assoc())
                    {
                        ?>
                            <div class="left">
                                <div class="main_image">
                                    <img src="<?php echo $row["Img1"] ?>" alt=" " width="450" height="400" class="slide">
                                </div>

                                <div class="option flex">
                                    <img src="<?php echo $row["Img1"] ?>" alt="" onclick="img('<?php echo $row["Img1"] ?>')">
                                    <img src="<?php echo $row["Img2"] ?>" alt="" onclick="img('<?php echo $row["Img2"] ?>')">
                                    <img src="<?php echo $row["Img3"] ?>" alt="" onclick="img('<?php echo $row["Img3"] ?>')">
                                </div>
                                
                                <div class="reviews">
                                    <h3 style="font-size: 20px; font-weight: bold; padding-bottom: 25px; margin-top: 20px;">Ratings & Reviews</h3>
                                    <?php
                                        $sql_feedback="SELECT fname,Ratings,Reviews FROM feedback,customer WHERE feedback.Product_id='$id'
                                         AND feedback.Customer_id=customer.Customer_id;";
                                        $result_feedback=$conn->query($sql_feedback); 
                                        if($result_feedback->num_rows > 0)
                                        {
                                            while($row_feedback=$result_feedback->fetch_assoc())
                                            {
                                                echo '<div class="review"><h4 class="review-text">' . $row_feedback['Reviews'] . '</h4>
                                                <div class="star">';
                                                //star rating
                                                for ($i = 0; $i < $row_feedback['Ratings']; $i++) 
                                                {
                                                    echo '<i class="fa-solid fa-star"></i>';
                                                }
                                                echo '</div><p class="review-customer">~ ' . $row_feedback['fname'] . '</p></div>';
                                            }
                                        }   
                                    ?>
                                </div>

                            </div>
                            <div class="right">
                                <h3 class="prod_desc_h3"><?php echo $row["Product_brand"] ?></h3>
                                <p class="prod_desc_name"><?php echo $row["Product_name"] ?></p>
                                <div class="leaf">
                                    <?php
                                        for ($i = 0; $i < $row['Eco_rating']; $i++) 
                                        {
                                            echo '<i class="fa-solid fa-leaf" style="margin: 1px;"></i>';
                                        }
                                    ?>
                                </div>
                                <h4 class="prod_desc_h4"><small>Rs </small><?php echo $row["discounted_price"] ?> <span id="actual_price"><?php echo $row["Price"] ?></span></h4>
                                <?php
                                    if($row['Qnty_in_stock']==0)
                                    {
                                        echo '<h5 style="color: red; font-size: 18px; font-weight: bold;">Out Of Stock!!</h5>';
                                    }
                                    else
                                    {
                                        echo '<h5 style="color:#132A13 ; font-size: 18px; font-weight: bold;">In Stock</h5>';
                                    }
                                ?>
                                
                                <p class="prod_desc_p"><?php echo $row["Description"] ?></p>
                                <h5 class="prod_desc_h5">Quantity</h5>

                                <form action="cart_update.php" method="post">
                                    <input type="hidden" name="prod_id" id="prod_id" value="<?php echo $row['Product_id']; ?>">
                                    <input type="number" id="qnty" name="qnty" value="1" min="1" max="5">
                                    <button type="submit">Add To Cart</button>
                                </form>

                                <h3 style="font-size: 20px; font-weight: bold; padding-bottom: 25px; margin-top: 100px;">Submit a Review</h3>
                                
                                <form onsubmit="return submitReview()" action="product_review_update.php" method="post">
                                    
                                    <textarea id="user_review" name="user_review" placeholder="Write your review here..." rows="4" cols="50" required></textarea>
                                    <br>
                                    <div class="star-rating">
                                        <button type="button" onclick="adjustRating(-1)"><i class="fa-solid fa-minus"></i></button>
                                        <div id="ratingDisplay" class="star"><h4 class="rating-text">Rate This Product</h4></div>
                                        <button type="button" onclick="adjustRating(1)"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <br>
                                    <input type="hidden" id="rating" name="rating">
                                    <input type="hidden" name="prod_id" id="prod_id" value="<?php echo $row['Product_id']; ?>">
                                    <button type="submit">Submit Review</button>
                                </form>
                            </div>
                            

                        <?php
                    }
                }
            ?>
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
    <script src="script.js"></script>
    <script>
        
        function img(anything)
        {
            document.querySelector('.slide').src=anything;
        }
        
        current_rating=0;
        function adjustRating(rating)
        {
            current_rating+=rating;
            if(current_rating<0)
            {
                current_rating=0;
            }
            else if(current_rating>5)
            {
                current_rating=5;
            }
            console.log(current_rating);
            document.getElementById('ratingDisplay').innerHTML='';
            for(i=1;i<=current_rating;i++)
            {
                star_icon=document.createElement('i');
                star_icon.className='fas fa-star';
                document.getElementById('ratingDisplay').appendChild(star_icon);
            }
        }

        function submitReview()
        {
            document.querySelector("#rating").value=current_rating;
        }

    </script>
</body>

</html>