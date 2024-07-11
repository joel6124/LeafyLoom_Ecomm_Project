<?php
include ('connection.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Validate the username and password (replace this with your validation logic)
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $paswd_register = $_POST["paswd_register"];
    $email = $_POST["e-id"];
    $phno = $_POST["ph_no"];
    $address = $_POST["address"];
    echo("$fname");
    $sql = "INSERT INTO `customer` (`Customer_id`, `fname`, `lname`, `Email_address`, `Password`, `Contact`, `Address`) 
            VALUES ('15', '$fname', '$lname', '$email', '$paswd_register', '$phno', '$address');";
    if($conn->query($sql)==true)
    {
        header("Location: login_register.html");
        echo "<script>alert('Login successful!');</script>";
    }
    else
    {
        echo "ERROR: $sql <br> $conn->error";
    }

    // $sql = "select Customer_id from customer";  
    // $result = mysqli_query($conn, $sql);  
    // print_r($result);
    // $row = mysqli_fetch_array($result);  
    // $count = mysqli_num_rows($result);  
    // print_r($row);   

    

    // if($count >0){        
    //     // Redirect to the index.html page
    //     header("Location: index.html");
    //     echo "<script>alert('Login successful!');</script>";
    //     exit; // Make sure to call exit after header() to prevent further execution
    // } else {
    //     // Authentication failed, redirect back to login page with error message
    //     echo "<script>alert('Login unsuccessful!');</script>";
    //     header("Location: login_register.html");
    //     exit;
    // }

    
    // if ($conn->query($sql) === true)
    // {
    //     // Successfully executed the query
    //     // You may add further actions or redirect the user after successful registration
    // } else {
    //     // Handle the case where the query execution failed
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }

    // Close the database connection
    $conn->close();
}
?>




<!-- // Example validation - replace with your actual authentication logic
    // $sql = "select * from customer where Email_address = '$username' and password = '$password'";  
    // $result = mysqli_query($conn, $sql);  
    // print_r($result);
    // $row = mysqli_fetch_array($result);  
    // $count = mysqli_num_rows($result);  
           
    // if($count >0){        
    //     // Redirect to the index.html page
    //     header("Location: index.html");
    //     echo "<script>alert('Login successful!');</script>";
    //     exit; // Make sure to call exit after header() to prevent further execution
    // } else {
    //     // Authentication failed, redirect back to login page with error message
    //     echo "<script>alert('Login unsuccessful!');</script>";
    //     header("Location: login_register.html");
    //     exit;
    // } -->