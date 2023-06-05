<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_books'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $description = $_POST['description'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $author = $_POST['author'];
   $genre = $_POST['genre'];
   
   $select_author_name = mysqli_query($conn, "SELECT name FROM `author` WHERE name = '$author'") or die('query failed');
   if(!mysqli_num_rows($select_author_name) > 0){
   $add_author= mysqli_query($conn, "INSERT INTO `author` (name) VALUES ('$author')") or die('query failed');
   }

   $select_genre_name = mysqli_query($conn, "SELECT genre_name FROM `genre` WHERE genre_name = '$genre'") or die('query failed');
   if(!mysqli_num_rows($select_genre_name) > 0){
   $add_genre= mysqli_query($conn, "INSERT INTO `genre`(genre_name) VALUES('$genre')") or die('query failed');
   }

   $select_book_name = mysqli_query($conn, "SELECT name FROM `books` WHERE name = '$name'") or die('query failed');
   if(mysqli_num_rows($select_book_name) > 0){
      $message[] = 'Book name already added';
   }else{
      $add_books_query = mysqli_query($conn, "INSERT INTO `books` (name, description, author, genre, image) VALUES ('$name', '$description', '$author', '$genre', '$image')") or die('query failed');
     

      if($add_books_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Book added successfully!';
         }
      }else{
         $message[] = 'book could not be added!';
      }
   }
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
.highlight-textarea {
   border: 1px solid #808080;
   background-color: #F2F2F2;
   padding: 3px;
   font-size: 10px;
   color: #333;
   outline: none;
}
</style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- book CRUD section starts  -->

<section class="add-books">

   <h1 class="title"> Add Books</h1>
<div class="card">
     <div class="card-body">
   <form action="" method="post" enctype="multipart/form-data">
      
      <textarea rows = "1" cols = "60" name="name" placeholder="Enter Book Name" class="box" required></textarea><br>
      <textarea rows = "1" cols = "60" name="author" placeholder="Enter Author Name" class="box" required></textarea><br>
      <textarea rows = "1" cols = "60" name="genre" placeholder="Enter Genre Type" class="box" required></textarea><br>
      <textarea rows = "5" cols = "60" name = "description" placeholder="Write Description...." class="box" required></textarea><br>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required><br>
      <input type="submit" value="add books" name="add_books" class="btn">
   </form>
</div>
</div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>