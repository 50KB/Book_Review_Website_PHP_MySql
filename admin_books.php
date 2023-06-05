<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `books` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `books` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `author` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `genre` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_books.php');
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


.rating {
  margin-top: 10px;
  display: flex;
  align-items: center;
}

.average-rating {
  font-size: 18px;
  font-weight: bold;
  margin-right: 10px;
}

.star-rating {
  color: #ffc107;
  font-size: 15px;
}

.fa-star {
  margin-right: 5px;
}

.checked {
  color: #ff9800;
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

.review-button {
   margin-top: 20px;
}

.review-button .button {
   background-color: #4CAF50;
   color: white;
   padding: 10px 20px;
   border: none;
   border-radius: 4px;
   font-size: 16px;
   cursor: pointer;
}

</style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>


<!-- show books  -->

<section class="books">
   <h1 class="title">All Books</h1>
   <div class="card">
      <div class="card-body">
         <?php
         $select_books = mysqli_query($conn, "SELECT * FROM `books`") or die('query failed');
         if(mysqli_num_rows($select_books) > 0){
            while($fetch_books = mysqli_fetch_assoc($select_books)){
         ?>
         <div class="card">
            <div class="card-body">
               <div class="book-details">
                  <div class="book-image">
                     <img src="uploaded_img/<?php echo $fetch_books['image']; ?>" alt="">
                  </div>
                  <div class="book-content">
                     <div class="rating">
                        <?php
                        $book_id = $fetch_books['id'];
                        $select_avg_rating = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM review WHERE book_id = $book_id");
                        $avg_rating_row = mysqli_fetch_assoc($select_avg_rating);
                        $average_rating = round($avg_rating_row['avg_rating'], 1);
                        ?>
                        <div class="stars">
                           <div class="star-rating">
                              <?php
                              for ($i = 1; $i <= 5; $i++) {
                                 if ($i <= $average_rating) {
                                    echo '<span class="fa fa-star checked"></span>';
                                 } else {
                                    echo '<span class="fa fa-star"></span>';
                                 }
                              }
                              ?>
                              <?php echo $average_rating; ?>
                           </div>
                        </div>
                     </div>
                     <div class="book-info">
                        <div class="name"><p><b>Name: </b><?php echo $fetch_books['name']; ?></p></div>
                        <div class="author"><p><b>Author: </b><?php echo $fetch_books['author']; ?></p></div>
                        <div class="genre"><p><b>Genre: </b><?php echo $fetch_books['genre']; ?></p></div>
                     </div>
                     <div class="book-description">
                        <p><?php echo $fetch_books['description']; ?></p>
                     </div>
                     
                  </div>
               </div>
               <a href="admin_update_book.php?update=<?php echo $fetch_books['id']; ?>" class="option-btn">Update</a>
         <a href="admin_books.php?delete=<?php echo $fetch_books['id']; ?>" class="delete-btn" onclick="return confirm('delete this Book?');">delete</a>
            </div>
         </div>
         <?php
            }
         } else {
            echo '<p class="empty">No books added yet!</p>';
         }
         ?>
      </div>
   </div>
</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>