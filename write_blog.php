<?php
session_start();

include("connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_SESSION['cust_id'])) 
    {
        $customer_id = $_SESSION['cust_id'];
        $blogTitle = isset($_POST["title"]) ? $_POST["title"] : 'Blog';
        $blogContent = isset($_POST["content"]) ? $_POST["content"] : '';
        $blogDate = date("Y-m-d");

        $uploadsDirectory = 'BlogBannerImage/';
        $fileName = $_FILES['blogPic']['name'];
        $destination = $uploadsDirectory . $fileName;

        $uploadedFile = $_FILES['blogPic']['tmp_name'];

        if (move_uploaded_file($uploadedFile, $destination)) 
        {
            $sql = "INSERT INTO blog (Customer_id, Blog_title, Blog_pic, Blog_content, Blog_date)
                    VALUES ('$customer_id', '$blogTitle', '$destination', '$blogContent', '$blogDate')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Blog posted successfully!');</script>";
            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 
        else 
        {
            echo "Error uploading file.";
        }
    } 
    else 
    {
        echo "<script>alert('Please SignUp/Login to post any Blog/Article!!  ');</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Blog!</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <form onsubmit="validate_blog_content()" action="write_blog.php" method="post" enctype="multipart/form-data">
        <div class="banner">
            <img src="img/default_banner_write_blog.jpg" id="upload_pic" alt="" height="100%" width="100%">
            <input name="blogPic" id="banner_upload" type="file" accept="image/*" hidden>
            <label for="banner_upload" class="banner_upload_btn"><span id="write_blog_banner_span">Select Image for Blog Post</span><i class="fa-solid fa-upload"></i></label>
        </div>
    
        <div class="write_blog">
            <textarea name="title" id="title" class="title" placeholder="Write your Blog title here..."></textarea>
            <textarea name="content" id="content" class="article" placeholder="Write your Blog content here..."></textarea>
        </div>
    
        <div class="blog-options">
            <button type="submit" class="btn_publish">Publish</button>
        </div>
    </form>

    <script src="write_blog.js"></script>
    <script src="blog.js"></script>
    <script>
        function validate_blog_content()
        {
            var tilte=document.querySelector('#title').value;
            var content=document.querySelector('#content').value;
            if(title=="" || content=="")
            {
                alert("Kindly fill-in your blog content!");
            }
        }
    </script>
</body>
</html>





<?php
// // Assuming you have received blog content via POST method
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $content = $_POST["content"];

//     // Keyword analysis
//     $ecoKeywords = array("environment", "sustainability", "green living", "recycling", "renewable energy");
//     $offensiveKeywords = array("vulgar_word1", "offensive_phrase2", "inappropriate_word3");

//     $ecoCount = 0;
//     $offensiveCount = 0;

//     foreach ($ecoKeywords as $keyword) {
//         if (stripos($content, $keyword) !== false) {
//             $ecoCount++;
//         }
//     }

//     foreach ($offensiveKeywords as $keyword) {
//         if (stripos($content, $keyword) !== false) {
//             $offensiveCount++;
//         }
//     }

//     // Determine content relevance
//     if ($ecoCount > $offensiveCount) {
//         echo "Success: Content is related to eco-friendly topics.";
//         // Proceed with posting the content to the website
//     } else {
//         echo "Error: Content is either offensive or not related to eco-friendly topics.";
//         // Display an error message and prevent posting
//     }
// }
?>
