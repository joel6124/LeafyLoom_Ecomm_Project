<?php
include('connection.php');  
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email,$ver_code,$fname)
{
    require('PHPMailer/PHPMailer.php');
    require('PHPMailer/SMTP.php');
    require('PHPMailer/Exception.php');

    $mail = new PHPMailer(true);

        
    try 
    {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'leafyloom.ecomm@gmail.com';                     //SMTP username
        $mail->Password   = 'djspuzegdtkqexup';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('leafyloom.ecomm@gmail.com', 'LeafyLoom');
        $mail->addAddress($email, 'LeafyLoom');     //Add a recipient
        //content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verify Your Email Address - LeafyLoom';
        $mail->Body    = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                .button {
                    background-color: #4CAF50;
                    color: white;
                    font-weight: bold;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    text-decoration: none;
                    cursor: pointer;
                    display: inline-block;
                }
            </style>
        </head>
        <body>
            <p>Dear $fname,</p>
            <p>Thank you for registering with LeafyLoom! To complete your registration and verify your email address, please click the button below:</p>
            <a class='button' href='http://localhost/proj_code_final/verify_email.php?email=$email&ver_code=$ver_code'>Verify Email</a>
            <br>
            <p>If you did not register on our platform, please disregard this email.</p>
            <br>
            <p>Best regards,<br>LeafyLoom Team</p>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } 
    catch (Exception $e) 
    {
        return false;
    }
}

$alert_message = isset($_GET['alert_message']) ? urldecode($_GET['alert_message']) : '';
if (isset($_POST['uname'])) 
{
    $username = $_POST["uname"];
    $password = $_POST["paswd_login"];
    $sql = "SELECT * FROM customer WHERE Email_address = '$username'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0)
    {
        $row = mysqli_fetch_assoc($result);
        if($row['is_verified']==1)
        {
            if ($row && password_verify($password, $row['Password'])) 
            {
                $_SESSION['userlogin'] = true;
                $_SESSION['username'] = $row['fname'];
                $_SESSION['cust_id'] = $row['Customer_id'];
                header("Location: index.php");
                exit();
            } 
            else 
            {
                $_SESSION['userlogin'] = false;
                echo "<script>alert('Login Unsuccessfull!  Invalid username or password.'); window.location.href = 'login_register.php';</script>";
                exit();
            }
        }
        else
        {
            echo "<script>alert('Email not Verified!!'); window.location.href = 'login_register.php';</script>";
        }
    }
    else
    {
        echo "<script>alert('Email not Registered!!'); window.location.href = 'login_register.php';</script>";
    }

}
if(isset($_POST["fname"])) 
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $paswd_register = $_POST["paswd_register"];
    // Hash the password
    $hashed_password = password_hash($paswd_register, PASSWORD_DEFAULT);
    $email = $_POST["e-id"];
    $phno = $_POST["ph_no"];
    $address = $_POST["address"];

    $user_exits = "SELECT * FROM customer WHERE fname='$fname' AND lname='$lname' || Email_address='$email'";
    $result = $conn->query($user_exits);
    if($result->num_rows>0)
    {
        echo "<script>alert('Username and Email already used!!'); window.location.href = 'login_register.php';</script>";
    }
    else
    {
        //get the latest Customer_id
        $latest_customer_query = "SELECT MAX(SUBSTRING(Customer_id, 4)) as latest_customer FROM customer";
        $result = $conn->query($latest_customer_query);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $latest_customer_number = intval($row['latest_customer']);
            $next_customer_number = $latest_customer_number + 1;
        } 
        else 
        {
            $next_customer_number = 1;
        }

        $customer_id = 'CUS' . sprintf("%03d", $next_customer_number);
        $ver_code=bin2hex(random_bytes(16));
        $sql = "INSERT INTO `customer` (`Customer_id`, `fname`, `lname`, `Email_address`, `Password`, `Contact`, `Address`,  `verification_code`,  `is_verified`) 
                VALUES ('$customer_id', '$fname', '$lname', '$email', '$hashed_password', '$phno', '$address','$ver_code','0');";

        if($conn->query($sql) == true && send_mail($email,$ver_code,$fname)) 
        {
            echo "<script>alert('Registered Sucessfully!! Kindly vist you mail and verify your Email address!'); window.location.href = 'login_register.php';</script>";

            $pts=0;
            $sql_add_user_to_rewards = "INSERT INTO rewards (Customer_id,Points) VALUES (?,?)";
            $stmt_add_to_rewards = $conn->prepare($sql_add_user_to_rewards);
            $stmt_add_to_rewards->bind_param("si", $customer_id, $pts);
            $stmt_add_to_rewards->execute();
            $result = $stmt_chk->get_result();
            $stmt_add_to_rewards->close();
        } 
        else 
        {
            echo "<script>alert('Error with query or email!! (SERVER DOWN)');</script>";
        }

        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Log in to LeafyLoom </title> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>

body
{    
    background-image: url('img/login_bg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    
}   

.wrapper
{
    background: transparent;
    position: absolute;
    top: 190px;
    left: 35%;
    width: 400px;
    height: 500px;
    border: 2px solid #132A13;
    backdrop-filter: blur(20px);
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 20px;
    transform: scale(1);
    transition: 0.2s ease;
    overflow: hidden;
} 

.wrapper.active
{
    height: 500px;
    width: 600px;
    left: 28%;
}

.wrapper .form-box.login
{
    transition: .18s ease;
    transform: translateX(0);  
}
.wrapper.active .form-box.login
{
    transition: none;
    transform: translateX(700px);
}

.wrapper .form-box.register
{
    position: absolute;
    transition: none;
    transform: translateX(-900px);
}
.wrapper.active .form-box.register
{
    transition: .18s ease;
    transform: translateX(0);
}

.wrapper .form-box
{
    width: 100%;
    padding: 40px;

}
.form-box h2
{
    text-align: center;
}
.wrapper .input-box
{
    position: relative;
    width: 100%;
    height: 50px;
    border-bottom: 2px solid #132A13;
    margin: 30px 0;
}
.wrapper .input-register
{
    display: flex;
    
}
.wrapper .input-box.register
{
    margin: 10px 10px;
}
.wrapper .input-box.register.paswd
{
    width: 95%;
}
.wrapper .input-box label
{
    position: absolute;
    top: 50%;
    left: 5px;
    transform: translateY(-50%);
    font-size: 1em;
    color:#31572c;
    font-weight: 600;

}
.wrapper .input-box input
{
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    font-size: 1em;
    color:#132A13;
    font-weight: bold;
    padding: 0 35px 0 5px;
}

.input-box input:focus~label,
.input-box input:valid~label
{
    top: -5px;
}
.input-box .icon
{
    position: absolute;
    right: 8px;
    font-size: 1.2em;
    color:#132A13;
    line-height: 57px;
}


.wrapper .btn
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
.wrapper .login-register
{
    font-size: .9em;
    text-align: center;
    font-weight: 500;
    margin: 25px 0 10px;
}
.wrapper .login-register p a
{
    color: #132A13;
    text-decoration: none;
    font-weight: 600;
    padding: 5px;
}
.wrapper .login-register p a:hover
{
    text-decoration: underline;
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
                <li><a  class="active" href="<?php echo isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true ? '#' : 'login_register.php'; ?>" id="user_pf"><i class="fa-solid fa-user"></i>
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
    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <form action="login_register.php" method="post">
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <input id="uname" name="uname" type="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input id="paswd_login" name="paswd_login" type="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn" value="submit">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a class="register-link" href="#" class="register">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form onsubmit="return validateRegistration()" action="login_register.php" method="post">
                <div class="input-register">
                    <div class="input-box register">
                        <span class="icon"><i class="fa-regular fa-id-card"></i></span>
                        <input id="fname" name="fname" type="text" required>
                        <label>First Name</label>
                    </div>
                    <div class="input-box register">
                        <span class="icon"><i class="fa-regular fa-id-card"></i></span>
                        <input id="lname" name="lname" type="text" required>
                        <label>Last Name</label>
                    </div>
                </div>
                <div class="input-box register paswd">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input id="paswd_register" name="paswd_register" type="password" required>
                    <label>Password</label>
                </div>
                <div class="input-register">
                    <div class="input-box register">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <input id="e-id" name="e-id" type="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box register">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <input id="ph_no" name="ph_no" type="number" required>
                        <label>Mobile Number</label>
                    </div>
                </div>
                <div class="input-box register">
                    <input id="address" name="address" type="text" required>
                    <label>Address</label>
                </div>
                <button type="submit" class="btn" value="submit">Register</button>
                <div class="login-register">
                    <p>Have an account? <a class="login-link" href="#" class="Login">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <?php
        if (!empty($alert_message)) {
            echo "<script>alert('$alert_message');</script>";
        }
    ?>
    
    <script src="script.js"></script>
    <script>
            const login_popup=document.querySelector(".wrapper");
            const loginlink=document.querySelector(".login-link");
            const registerlink=document.querySelector(".register-link");

            registerlink.addEventListener('click',() => {
                login_popup.classList.add('active');
            });

            loginlink.addEventListener('click',() => {
                login_popup.classList.remove('active');
            });


            /*register validation*/
            function validateRegistration() 
            {
                var firstName = document.getElementById("fname").value;
                if (!/^[a-zA-Z]+$/i.test(firstName)) 
                {
                    alert("First Name cannot be empty.");
                    return false;
                }

                var lastName = document.getElementById("lname").value;
                if (!/^[a-zA-Z]+$/i.test(lastName)) 
                {
                    alert("Last Name cannot be empty.");
                    return false;
                }

                var password = document.getElementById("paswd_register").value;
                if (password.length < 6) {
                    alert("Password should be at least 6 characters long.");
                    return false;
                }

                var email = document.getElementById("e-id").value;
                if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                    alert("Invalid Email address.");
                    return false;
                }

                var mobileNumber = document.getElementById("ph_no").value;
                if (!/^\d{10}$/.test(mobileNumber)) {
                    alert("Mobile Number should contain 10 digits only.");
                    return false;
                }

                var address = document.getElementById("address").value;
                if (address.trim() === "") 
                {
                    alert("Address cannot be empty.");
                    return false;
                }
                return true;
            }

    </script>
</body>

</html>