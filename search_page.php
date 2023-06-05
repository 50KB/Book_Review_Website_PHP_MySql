<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
   .heading{
    min-height: 30vh;
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    background: url(../images/every-leader-should-read.webp);
    background-size: cover;
    background-position: center;
    text-align: center;
}
.heading h3 {
    font-size: 5rem;
    color: var(--black);
    text-transform: uppercase;
}

.heading p {
    font-size: 2.5rem;
    color: var(--light-color);
}

.heading p a {
    color: var(--purple);
}

.heading p a:hover {
    text-decoration: underline;
}

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


</style>


</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Search A Book</h3>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Enter Book Name or Genre or Author..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>

<section class="books" style="padding-top: 0;">

<div class="card">
   <div class="card-body">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_books = mysqli_query($conn, "SELECT * FROM `books` WHERE name LIKE '%{$search_item}%' OR genre LIKE '%{$search_item}%' OR author LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_books) > 0){
         while($fetch_book = mysqli_fetch_assoc($select_books)){
   ?>
   <div class="box">
      <img src="uploaded_img/<?php echo $fetch_book['image']; ?>" alt="">
      <div class="rating">
      <?php
      $book_id = $fetch_book['id'];
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
         <div class="name"><p style="color:black;font-size:20px;"><b>Name: </b><?php echo $fetch_book['name']; ?></p></div>
         <div class="author"><p style="color:black;font-size:15px;"><b>Author: </b><?php echo $fetch_book['author']; ?></p></div>
         <div class="genre"><p style="color:black;font-size:15px;"><b>Genre: </b><?php echo $fetch_book['genre']; ?></p></div>
         <div class=" card description"><?php echo $fetch_book['description']; ?></div>
         <button class=' button button1'>
         <a href="review.php?book_id=<?php echo $fetch_book['id']; ?>" class="review-button">Review</a>
         </button>
      </div>
      </div>
      </div>

   <?php
            }
         }else{
            echo '<p class="empty">no result found!</p>';
         }
      }else{
         echo '<p class="empty">search something!</p>';
      }
   ?>
   </div>
  

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>