<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

<style>

.button {
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button1 {background-color: #4CAF50;} /* Green */

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
   
<?php include 'header.php'; ?>


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
               <div class="review-button">
                        <a href="review.php?book_id=<?php echo $fetch_books['id']; ?>" class="button button1">Review</a>
                     </div>
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





<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>