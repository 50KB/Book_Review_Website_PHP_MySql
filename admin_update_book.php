<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};



if(isset($_POST['update_book'])){

    $update_b_id = $_POST['update_b_id'];
    $update_name = $_POST['update_name'];
    $update_author = $_POST['update_author'];
    $update_genre = $_POST['update_genre'];
    $update_description = $_POST['update_description'];
    if (!empty($update_name)) {
        $Update_name_query = mysqli_query($conn, "UPDATE `books` SET name = '$update_name' WHERE id = '$update_b_id'") or die('query failed');
    }
    if (!empty($update_author)) {
        $Update_author_query = mysqli_query($conn, "UPDATE `books` SET author = '$update_author' WHERE id = '$update_b_id'") or die('query failed');
    }
    if (!empty($update_genre)) {
        $Update_genre_query = mysqli_query($conn, "UPDATE `books` SET genre ='$update_genre' WHERE id = '$update_b_id'") or die('query failed');
    }
    if (!empty($update_description)) {
        $Update_description_query = mysqli_query($conn, "UPDATE `books` SET description = '$update_description' WHERE id = '$update_b_id'") or die('query failed');
    }
    
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
    
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'image file size is too large';
       }else{
        $Update_image_query = mysqli_query($conn, "UPDATE `books` SET image = '$update_image' WHERE id = '$update_b_id'") or die('query failed');
          move_uploaded_file($update_image_tmp_name, $update_folder);
          unlink('uploaded_img/'.$update_old_image);
       }
    }
        
        $message[] = 'Book Updated Successfully!';
    
    }
    
    ?>
    
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Books</title>
    
       <!-- font awesome cdn link  -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
       <!-- custom admin css file link  -->
       <link rel="stylesheet" href="css/admin_style.css" type="text/css">
    <style>
             /* description card*/
    .card {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
        display: inline-block;
        box-sizing: border-box;
        width: 100%;
    }
    
    .card .description {
        margin-bottom: 10px;
        text-align: left;
        font-family: sans-serif;
    
    }
    
    .card .card-header {
        text-align: left;
    }
    
    .card .card-body {
        text-align: left;
    }
    .book-details {
   display: flex;
   align-items: center;
}

.book-image {
   width: 200px;
   margin-right: 20px;
}

.book-image img {
   width: 100%;
   height: auto;
   border-radius: 4px;
}

.book-content {
   flex: 1;
}

.book-info {
   margin-bottom: 10px;
}

.book-info p {
   color: #555;
   font-size: 14px;
}

.book-description p {
   color: #777;
   font-size: 14px;
}
.highlight-textarea {
   border: 2px solid #808080;
   background-color: #F2F2F2;
   padding: 5px;
   font-size: 16px;
   color: #333;
   outline: none;
   border-radius: 5px;
}

</style>
    
</head>
    <body>
       
    <?php include 'admin_header.php'; ?>

<section class="edit-book-form">
<h1 class="title"> Edit Books</h1>
<div class="card">
     <div class="card-body">
   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `books` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
   <input type="hidden" name="update_b_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt=""><br><br>
      <div class="name"><p style="color:black;font-size:20px;"><b>Name: </b><?php echo $fetch_update['name']; ?></p></div>
      <div class="author"><p style="color:black;font-size:15px;"><b>Author: </b><?php echo $fetch_update['author']; ?></p></div>
      <div class="genre"><p style="color:black;font-size:15px;"><b>Genre: </b><?php echo $fetch_update['genre']; ?></p></div>
      <div class=" card description"><?php echo $fetch_update['description']; ?></div><br><br><br>
      <textarea rows = "1" cols = "60" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="highlight-textarea" placeholder="enter book name"></textarea><br>
      <textarea rows = "1" cols = "60" name="update_author" placeholder="Enter Author Name" class="highlight-textarea" ></textarea><br>
      <textarea rows = "1" cols = "60" name="update_genre" placeholder="Enter Genre Type" class="highlight-textarea"></textarea><br>
      <textarea rows = "5" cols = "60" name = "update_description" placeholder="Write Description...."class="highlight-textarea"></textarea><br>
      <input type="file" class="highlight-textarea" name="update_image" accept="image/jpg, image/jpeg, image/png"><br>
      <input type="submit" value="update" name="update_book" class="btn">
      <a href="admin_books.php" class="option-btn">Cancel</a>

   </form>
      </div>
      </div>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-book-form").style.display = "none";</script>';
      }
   ?>

</section>
<script>
    function cancelUpdate() {
        window.location.href = 'admin_books.php';
    }
</script>


<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
    