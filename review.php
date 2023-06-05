<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}


// Check if the book ID is provided in the URL
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Fetch book details from the database
    $bookQuery = "SELECT * FROM books WHERE id = $bookId";
    $bookResult = mysqli_query($conn, $bookQuery);

    // Check if the book exists
    if (mysqli_num_rows($bookResult) > 0) {
        $book = mysqli_fetch_assoc($bookResult);
        ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review - <?php echo $book['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

<style>
    
.review-card {
  background-color: #f5f5f5;
  padding: 10px;
  margin-bottom: 20px;
  border-radius: 5px;
}

.comment {
  margin-bottom: 5px;
}

.rating {
  color: #ffc107; /* Yellow color for stars */
  margin-bottom: 5px;
}

.posted-by,
.post-date {
  margin-bottom: 0;
}

.star {
  display: inline-block;
  width: 16px;
  height: 16px;
  position: relative;
  color: #FFD700;
  font-size: 16px;
  line-height: 1;
  margin-right: 2px;
}

.star::before {
  content: '\2606';
  position: absolute;
  top: 0;
  left: 0;
}

.star.filled::before {
  content: '\2605';
}

/* for new review */
.card {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
}

.card-header {
    background-color: #f2f2f2;
    padding: 2px;
    margin-bottom: 2px;
}

.card-body {
    margin-bottom: 10px;
}

.rating {
    margin-bottom: 10px;
}

.rating label {
    display: inline-block;
    width: 25px;
    height: 25px;
    margin: 0;
    padding: 0;
    font-size: 25px;
    color: #ffd700;
    cursor: pointer;
}

.rating label:hover,
.rating label:hover ~ label,
.rating input[type="radio"]:checked ~ label {
    color: #ffcc00;
}

.form-group {
    margin-bottom: 10px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
.box-container{
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.highlight-textarea {
   border: 2px solid #808080;
   background-color: #F2F2F2;
   padding: 5px;
   font-size: 16px;
   color: #333;
   outline: none;
}


</style>
     
    </head>
    <body>
    <!-- custom js file link  -->
    <?php include 'header.php'; ?>
    
    <div class="box-container" style="width:30%;">
    
    <h1 >Book Review - <?php echo $book['name']; ?></h1>

   <?php
         $select_books = mysqli_query($conn, "SELECT * FROM `books`WHERE id = $bookId") or die('query failed');
         if(mysqli_num_rows($select_books) > 0){
            while($fetch_books = mysqli_fetch_assoc($select_books)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_books['image']; ?>" alt="">
         <div class="box-container" style="width:50%;">
         <div class="name"><b>Name:</b><?php echo $fetch_books['name']; ?></div>
         <div class="author"><b>Author:</b><?php echo $fetch_books['author']; ?></div>
         <div class="genre"><b>Genre:</b><i><?php echo $fetch_books['genre']; ?></i></div>
            </div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no books added yet!</p>';
      }
      ?>
   </div>

            <h2>Reviews</h2>

            <?php
            // Fetch reviews for the book
            $reviewQuery = "SELECT * FROM review WHERE book_id = $bookId";
            $reviewResult = mysqli_query($conn, $reviewQuery);

            // Display reviews
            if (mysqli_num_rows($reviewResult) > 0) {
                while ($review = mysqli_fetch_assoc($reviewResult)) {
                    echo "<div class='review-card'>";
                    echo "<div class='rating'>Rating:" . generateStarRating($review['rating']) . "</div>";
                    echo "<p class='comment'>Comment: " . $review['comment'] . "</p>";
                    echo "<p class='posted-by'>Posted by: " . $review['reviewer_name'] . "</p>";
                    echo "<p class='post-date'>Post Date: " . $review['date_posted'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews found for this book.</p>";
            }
            ?>

<div class="card">
    <div class="card-header">
        <h2>Write a Review</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="submit_review.php">
            <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
            <label for="comment">Rating:</label>
            <div class="rating">
                <label for="star1" title="1 stars">
                    <input type="radio" id="star1" name="rating" value="1" required>
                </label>
                <label for="star2" title="2 stars">
                    <input type="radio" id="star2" name="rating" value="2" required>
                </label>
                <label for="star3" title="3 stars">
                    <input type="radio" id="star3" name="rating" value="3" required>
                </label>
                <label for="star4" title="4 stars">
                    <input type="radio" id="star4" name="rating" value="4" required>
                </label>
                <label for="star5" title="5 star">
                    <input type="radio" id="star5" name="rating" value="5" required>
                </label>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"rows = "5" cols = "60" class="highlight-textarea" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>

            
        </body>
        </html>

        <?php
    } else {
        echo "<p>Book not found.</p>";
    }
}

// Function to generate star rating HTML based on the rating value
function generateStarRating($rating)
{
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $html .= '<span class="star filled"></span>';
        } else {
            $html .= '<span class="star"></span>';
        }
    }
    return $html;
}


?>

<script src="js/script.js"></script>


