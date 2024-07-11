<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
        .left, .right {
            width: 50%;
            padding: 30px;
        }
        
        .flex {
            display: flex;
            justify-content: space-between;
        }
        
        .flex1 {
            display: flex;
        }
        
        .main_image {
            width: auto;
            height: auto;
        }
        
        .option img {
            width: 75px;
            height: 75px;
            padding: 10px;
        }
        
        .right {
            padding: 50px 100px 50px 50px;
        }
        
        .prod_desc_h3 {
            color:#132A13;
            margin: 20px 0 10px 0;
            font-size: 25px;
        }
        

        .prod_desc_h4,
        small {
            color:#4f772d;
        }
        
        .prod_desc_h5 {
            color:#132A13;
        }
        
        .prod_desc_p {
            margin: 20px 0 30px 0;
            line-height: 25px;
        }
        
        .prod_desc_h5 {
            font-size: 15px;
        }
        
        label,
        .add span
        {
            width: 25px;
            height: 25px;
            background: #000;
            border-radius: 50%;
            margin: 20px 10px 20px 0;
        }
        
        .add label,
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
        }
        
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
        
        @media only screen and (max-width:768px) {
            .container {
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
        <a href="home.html"><img src="img/logo.png" alt="LeafyLoom" width="120" height="120"></a>
        <!-- <a id="logo" href="home.html">LeafyLoom</a> -->
        <div>
            <ul id="navbar">
                <li><a   class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#aboutus">About</a></li>
                <li><a href="community_wareness.php">Community & Awareness</a></li>
                <li><a href="rewards.php">Rewards</a></li>
                <li><a href="#footer">Contact Us</a></li>
                <li><a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a href="login_register.php" id="user_pf"><i class="fa-solid fa-user"></i></a></li>

            </ul>
        </div>

    </section>

    <section id="shop">
        <div class = "sidebar">
            <input type = "text" id = "text-search" placeholder = "Search Products"/>
            <h3> Categories </h3>
            <ul>
                <li><a href="Gifts.html">Gifts</a></li>
                <li><a href="PersonalCare.html">Personal Care</a></li>
                <li><a href="Kitchen.html">Kitchen</a></li>
                <li><a href="CleaningSupplies.html">Cleaning Supplies</a></li>
                <li><a href="TravelSupplies.html">Travel Supplies</a></li>
            </ul>
        </div>

        <div class="container flex">
            <div class="left">
                <div class="main_image">
                    <img src="img/shoe.png" alt="" width="450" height="400" "slide">
                </div>
                <div class="option flex">
                    <img src="img/bamboostraws.png" alt="" onclick="img('img/p1.jpg')">
                    <img src="img/bamboostraws.png" alt="" onclick="img('img/p1.jpg')">
                    <img src="img/bamboostraws.png" alt="" onclick="img('img/p1.jpg')">
                    <img src="img/bamboostraws.png" alt="" onclick="img('img/p1.jpg')">
                </div>
            </div>
            <div class="right">
                <h3 class="prod_desc_h3">Kyrgies</h3>
                <p class="prod_desc_p">Ethical Wool Molded Sole Slipper</p>
                <h4 class="prod_desc_h4"><small>Rs </small>640</h4>
                <p class="prod_desc_p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam autem debitis ipsa id deleniti dicta accusamus libero ullam repellat, quas, facere aliquam, dolorum labore consectetur vel ad itaque suscipit nesciunt.</p>
                <h5 class="prod_desc_h5">Quantity</h5>
                <div class="add flex1">
                    <span>-</span>
                    <label class="qnty">1</label>
                    <span>+</span>
                </div>
                <button>Add To Cart</button>
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

    <script>
        function img(anything)
        {
            document.querySelector('.slide').src=anything;
        }

        function change(change) 
        {
            const line = document.querySelector('.home');
            line.style.background = change;
        }
    </script>
</body>

</html>