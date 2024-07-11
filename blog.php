<?php
session_start(); // Start the session

include("connection.php");

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['cust_id'])) 
    {
        $customer_id = $_SESSION['cust_id'];
        // Use isset() to check if the keys exist in $_POST
        $blogTitle = isset($_POST["Blog_title"]) ? $_POST["Blog_title"] : '';
        $blogContent = isset($_POST["Blog_content"]) ? $_POST["Blog_content"] : '';
        $blogDate = date("Y-m-d"); // Current date

        // Handle file upload
        $uploadsDirectory = 'BlogBannerImage/'; // Your upload directory
        $uploadedFile = $_FILES['Blog_pic']['tmp_name'];
        $fileName = $_FILES['Blog_pic']['name'];
        $destination = $uploadsDirectory . $fileName;

        if (move_uploaded_file($uploadedFile, $destination)) 
        {
            $sql = "INSERT INTO blog (Customer_id, Blog_title, Blog_pic, Blog_content, Blog_date)
                    VALUES ('$customer_id', '$blogTitle', '$destination', '$blogContent', '$blogDate')";

            if ($conn->query($sql) === TRUE) {
                echo "Blog post inserted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 
        else 
        {
            echo "Error uploading file.";
        }
    } 
    else {
        echo "Error: Customer ID not found in session.";
    }
}

// Close the database connection
$conn->close();
?>
