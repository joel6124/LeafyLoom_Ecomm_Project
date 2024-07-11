<?php
    include("connection.php");
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
</head>
<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="LeafyLoom" width="120" height="120"></a>
        <!-- <a id="logo" href="home.html">LeafyLoom</a> -->
        <div id="navbar">
            <ul id="navbar" class="center-nav">
                <li><a href="index.php">Home</a></li>
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
    
    <div class="delivery-content">
        <div class="form-delivery">
            <h2 class="checkout_header">Checkout</h2>
            <p class="delivery_title">Delivery Address</p>
            <form onsubmit="return confirmAddress(event)">
                <input type="text" id="del_address" name="del_address" placeholder="House No and Name" required>
                <input type="text" id="del_street" name="del_street" placeholder="Street" required>
                <div class="three-delivery-inp">
                    <input type="text" id="del_city" name="del_city" placeholder="City" required>
                    <input type="text" id="del_state" name="del_state" placeholder="State" required>
                    <input type="number" id="del_pincode" name="del_pincode" placeholder="Pincode" required>
                </div>
                <button type="submit">Confirm Address</button>
            </form>

        </div>
        <div>
            <img src="img/bio.png" alt="image-bio">
            <h2>Embrace the <span>#ZeroWasteLifestyle</span> for a greener tomorrow!</h2>
        </div>
    </div>
    
    <section id="cart">
        <?php
            if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == true) 
            {   
                echo '<p id="heading">Order Summary</p>
                <div id="order_summary">
                    <table width = "60%">
                        <tbody>';
                    $sql = "SELECT Img1 as img,cart.Product_id as prod_id ,Product_brand, Product_name, Price, discounted_price, Qnty FROM cart,products WHERE cart.Product_id=products.Product_id AND cart.Customer_id=?";
                    
                        // Prepare and bind the statement
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $_SESSION['cust_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo '<tr>
                                    <td><img src="' . $row['img'] . '"></td>
                                    <td><p>' . $row['Product_brand'] .'</p>' . $row['Product_name'] .'</td>
                                    <td><input type="number" value="' . $row['Qnty'] .'" readonly></td>
                                    <td>Rs ' . ($row['Qnty'] * $row['discounted_price']) .'</td>
                                    <td><a href="cart_delete.php?prod_id=' . $row['prod_id'] .'"><i class="fa-solid fa-trash"></i></a></td>
                                </tr>';               
                        }
                        $stmt->close();
                        
                        echo '</tbody>
                        </table>';

                    echo '
                    
                        <div id="subtotal">
                            <h3> Price Details </h3>
                            <table>
                                <tr>
                                    <td>Price </td>';
                                    $subtotal = 0.0;
                                    $discount=0.0;
                                    $sql = "SELECT  Qnty,discounted_price,Price FROM cart,products WHERE cart.Product_id=products.Product_id AND cart.Customer_id=?";
                                    // Prepare and bind the statement
                                    $sbtot = $conn->prepare($sql);
                                    $sbtot->bind_param("s", $_SESSION['cust_id']);
                                    $sbtot->execute();
                                    $result = $sbtot->get_result();
                                    if($result->num_rows == 0)
                                    {
                                        $subtotal=0.0;
                                        $discount=0.0;
                                    }
                                    else
                                    {
                                        while ($row = $result->fetch_assoc()) 
                                        {
                                            $subtotal+=($row['Qnty'] * $row['discounted_price']);
                                            $discount+=(($row['Price']-$row['discounted_price'])*$row['Qnty']);
                                        }
                                    }
                                    echo '<td><strong>Rs ' . ($subtotal+$discount) . '</strong></td>
                                </tr>
                                <tr>
                                    <td> Discount </td>
                                    <td style="color: #31572C;"><strong>- Rs ' . $discount . '</strong></td>
                                </tr>
                                <tr>
                                    <td> Shipping </td>
                                    <td style="color: #31572C;"><strong> Free </strong></td>
                                </tr>
                                <tr>
                                    <td><strong class="total"> Total Amount </strong></td>';
                                    $sql = "SELECT Points FROM rewards WHERE Customer_id=?";
                                    $reward = $conn->prepare($sql);
                                    $reward->bind_param("s", $_SESSION['cust_id']);
                                    $reward->execute();
                                    $result = $reward->get_result();
                                    $row = $result->fetch_assoc();
                                    if($row['Points'] == 0)
                                    {
                                        echo '<td class="total">Rs ' . $subtotal . ' </td>';
                                    }
                                    else
                                    {
                                        echo '<td><strong class="total" id="total_amt">Rs ' . $subtotal . '</strong><span><input type="checkbox" name="reward_claim" id="reward_claim" onclick="$subtotal=update_subtotal_reward(this,' . $row['Points'] . ',' .$subtotal . ')">
                                    <label for="reward_claim">Claim Reward (' . $row['Points'] .' Points)</label></span></td>'; 
                                    }
                                    $conn->close();
                                    echo '
                                </tr>
                            </table>
                            <button onclick="proceedtopayment()">Proceed with Payment</button>
                        </div>
                    </div>';
            }
        ?>
    </section>

    <section id="payment">
        <p>Payment </p>
        <div class="pay-cont-flex">
            <div class="pay_container">
                <div class="pay_title">
                    <h4 style="color: #31572c">Select a <span style="color: #90A955">Payment</span> option</h4>
                </div>

                <form id="payment-form">
                    <input type="radio" name="payment" id="upi">
                    <input type="radio" name="payment" id="dr_cr">
                    <input type="radio" name="payment" id="cod">

                    <div class="category">
                        <label for="upi" class="upiMethod">
                            <div class="imgName">
                                <div class="imgContainer upi">
                                    <img class="payment_img" src="img/upi_mode.jpg" alt="">
                                </div>
                                <span class="name">UPI</span>
                            </div>
                            <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                        </label>

                        <label for="dr_cr" class="dr_crMethod">
                            <div class="imgName">
                                <div class="imgContainer dr_cr">
                                    <img class="payment_img" src="img/cr_dr_mode.jpg" alt="">
                                </div>
                                <span class="name">Credit/Debit Card</span>
                            </div>
                            <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                        </label>

                        <label for="cod" class="codMethod">
                            <div class="imgName">
                                <div class="imgContainer cod">
                                    <img class="payment_img" src="img/cod_mode.jpg" alt="">
                                </div>
                                <span class="name">Cash On Delivery</span>
                            </div>
                            <span class="check"><i class="fa-solid fa-circle-check" style="color: #90A955;"></i></span>
                        </label>

                    </div>
                </form>
            </div>

            <div class="form-payment" id="upi-form">
                <h4>UPI Payment</h4>
                <form onsubmit="return validate_payment_credentials(event)">
                    <input type="text" id="upi-id" placeholder="UPI ID" required>
                    <button type="submit">Confirm</button>
                </form>
            </div>

            <div class="form-payment" id="dr_cr-form">
                <h4>Credit/Debit Card Payment</h4>
                <form onsubmit="return validate_payment_credentials(event)">
                    <input type="number" id="card-number" placeholder="Card Number" required>
                    <input type="date" id="expiry-date" placeholder="Expiry Date" required>
                    <input type="number" id="cvv" placeholder="CVV" required>
                    <button type="submit">Confirm</button>
                </form>
            </div>

            <div class="form-payment" id="cod-form">
                <h4>Cash On Delivery</h4>
                <form onsubmit="return validate_payment_credentials(event)">
                    <input type="number" id="cod-phone" placeholder="Phone Number to Contact" required>
                    <button type="submit">Confirm</button>
                </form>
            </div>
        </div>
    </section>

    <div class="place-order">
        <p>Total Amount</p>
        <h2 id="bill-amt"><?php echo '₹'.$subtotal; ?></h2>
        <form  method="post" action="order_update.php" id="order-form">
            <input type="hidden" name="address" id="address" value="">
            <input type="hidden" name="street" id="street" value="">
            <input type="hidden" name="city" id="city" value="">
            <input type="hidden" name="state" id="state" value="">
            <input type="hidden" name="pincode" id="pincode" value="">
    

            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['cust_id']; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $subtotal; ?>">
            <input type="hidden" name="points_redeemed" id="points_redeemed">
            <input type="hidden" name="payment_mode" id="payment-mode">
            <button type="submit" id="place-order-btn" class="place-order-btn">Place Order</button>
        </form>

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

    <script>
        function confirmAddress(event) 
        {
            event.preventDefault();

            const pincodeRegex = /^\d{6}$/;
            const addressRegex = /^[a-zA-Z0-9\s,'-]*$/; 
            const cityStateStreetRegex = /^[a-zA-Z\s]*$/;

            const address = document.querySelector("#del_address").value.trim();
            const street = document.querySelector("#del_street").value.trim();
            const city = document.querySelector("#del_city").value.trim();
            const state = document.querySelector("#del_state").value.trim();
            const pincode = document.querySelector("#del_pincode").value.trim();

            if (!pincodeRegex.test(pincode)) {
                alert('Invalid Pincode!');
                return false;
            }
            if (!addressRegex.test(address)) {
                alert('Invalid Address!');
                return false;
            }
            if (!addressRegex.test(street)) {
                alert('Invalid Street!');
                return false;
            }
            if (!cityStateStreetRegex.test(city)) {
                alert('Invalid City!');
                return false;
            }
            if (!cityStateStreetRegex.test(state)) {
                alert('Invalid State!');
                return false;
            }
            if(!(cityStateStreetRegex.test(street)))
            {
                alert('Invalid Street!');
                return false;
            }

            const navbar = document.querySelector("#navbar");
            const cartSection = document.querySelector("#cart");
            const offsetTop = cartSection.offsetTop - (navbar.offsetHeight+100);
            window.scrollTo({ top: offsetTop, behavior: 'smooth' });
            return true;
        }

        function proceedtopayment()
        {
            const navbar=document.querySelector("#navbar");
            const paymentSection=document.querySelector("#payment");
            const offestTop=paymentSection.offsetTop - (navbar.offsetHeight+150);
            window.scrollTo({top: offestTop, behavior: 'smooth'});
        }


        function update_subtotal_reward(checkbox_reward,points,subtotal)
        {
            let total=subtotal;
            if(checkbox_reward.checked)
            {
                total-=points;
                document.querySelector("#points_redeemed").value = points;
            }
            document.querySelector("#total_amt").innerText="Rs "+ total;
            document.querySelector("#bill-amt").innerText="₹ "+total;
        }



        document.addEventListener("DOMContentLoaded", function () 
        {
            const upiForm = document.getElementById("upi-form");
            const drCrForm = document.getElementById("dr_cr-form");
            const codForm = document.getElementById("cod-form");

            document.getElementById("upi").addEventListener("change", function () {
                if (this.checked) {
                    upiForm.style.display = "flex";
                    drCrForm.style.display = "none";
                    codForm.style.display = "none";
                }
            });

            document.getElementById("dr_cr").addEventListener("change", function () {
                if (this.checked) {
                    upiForm.style.display = "none";
                    drCrForm.style.display = "flex";
                    codForm.style.display = "none";
                }
            });

            document.getElementById("cod").addEventListener("change", function () {
                if (this.checked) {
                    upiForm.style.display = "none";
                    drCrForm.style.display = "none";
                    codForm.style.display = "flex";
                }
            });
        });


        function validate_payment_credentials(event)
        {
            event.preventDefault();
            const upiForm = document.getElementById("upi");
            const drCrForm = document.getElementById("dr_cr");
            const codForm = document.getElementById("cod");
            if(upiForm.checked)
            {
                if(!(/^[a-zA-Z0-9]+@[a-z]+$/).test(document.querySelector("#upi-id").value.trim()))
                {
                    alert('Invalid UPI Id!!');
                    return false;
                }
                alert("UPI Id verified!!");
                return true;
            }
            if(drCrForm.checked)
            {
                if(!(/^\d{16}$/).test(document.querySelector("#card-number").value.trim()))
                {
                    alert('Invalid Card Number!!');
                    return false;
                }
                if(!(/^\d{4}-\d{2}-\d{2}$/).test(document.querySelector("#expiry-date").value.trim()))
                {
                    alert('Invalid Expiry Date!!');
                    return false;
                }
                if(!(/^\d{3}$/).test(document.querySelector("#cvv").value.trim()))
                {
                    alert('Invalid CVV!');
                    return false;
                }
                alert("Credentials verified!!");
                return true;
            }
            if(codForm.checked)
            {
                if(!(/^\d{10}$/).test(document.querySelector("#cod-phone").value.trim()))
                {
                    alert('Invalid Phone number to contact for Delivery!!');
                    return false;
                }
                alert("Phone number to contact for Delivery verified!!");
                return true;
            }
        }

        document.addEventListener("DOMContentLoaded", function () 
        {
            const addressInput = document.querySelector("#del_address");
            const streetInput = document.querySelector("#del_street");
            const cityInput = document.querySelector("#del_city");
            const stateInput = document.querySelector("#del_state");
            const pincodeInput = document.querySelector("#del_pincode");

            document.querySelector("#order-form").addEventListener("submit", function (event) 
            {
                // Prevent the default form submission
                    event.preventDefault();

                    const address = addressInput.value.trim();
                    const street = streetInput.value.trim();
                    const city = cityInput.value.trim();
                    const state = stateInput.value.trim();
                    const pincode = pincodeInput.value.trim();
                    const addressRegex = /^[a-zA-Z0-9\s,'-]*$/;
                    const cityStateStreetRegex = /^[a-zA-Z\s]*$/;
                    const pincodeRegex = /^\d{6}$/;

                    if(address==="" || street==="" || city==="" || state==="" || pincode==="")
                    {
                        alert('Kindly fill-in your address details!!');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        return;
                    }
                    if (!addressRegex.test(address)) 
                    {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        alert('Invalid Address!');
                        return;
                    }
                    if (!addressRegex.test(street)) 
                    {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        alert('Invalid Street!');
                        return;
                    }
                    if (!cityStateStreetRegex.test(city)) 
                    {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        alert('Invalid City!');
                        return;
                    }
                    if (!cityStateStreetRegex.test(state)) 
                    {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        alert('Invalid State!');
                        return;
                    }
                    if (!pincodeRegex.test(pincode)) 
                    {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        alert('Invalid Pincode!');
                        return;
                    }

                    document.querySelector("input[name='address']").value = address;
                    document.querySelector("input[name='street']").value = street;
                    document.querySelector("input[name='city']").value = city;
                    document.querySelector("input[name='state']").value = state;
                    document.querySelector("input[name='pincode']").value = pincode;

                    
                    const upiForm = document.getElementById("upi");
                    const drCrForm = document.getElementById("dr_cr");
                    const codForm = document.getElementById("cod");
                    if (!(upiForm.checked || drCrForm.checked || codForm.checked))
                    {
                        alert('Select a Payment Option!!');
                        return;
                    }

                    document.querySelector("#payment-mode").value = (upiForm.checked ? "UPI" : (drCrForm.checked ? "DR/CR card" : "COD"));

                    this.submit();
                });
        });

    </script>
    <script src="script.js"></script>
</body>
</html>