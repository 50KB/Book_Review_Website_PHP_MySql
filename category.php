<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// Fetch genres from the genre table
$genreQuery = "SELECT * FROM genre";
$genreResult = mysqli_query($conn, $genreQuery);

// Fetch authors from the author table
$authorQuery = "SELECT * FROM author";
$authorResult = mysqli_query($conn, $authorQuery);

// Fetch books based on the selected genre or author
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedGenre = $_POST['genre'];
    $selectedAuthor = $_POST['author'];

    $bookQuery = "SELECT * FROM books";
    $whereClause = "";

    if (!empty($selectedGenre)) {
        $whereClause .= " WHERE genre = '$selectedGenre'";
    }

    if (!empty($selectedAuthor)) {
        $whereClause .= empty($whereClause) ? " WHERE author = '$selectedAuthor'" : " AND author = '$selectedAuthor'";
    }

    $bookQuery .= $whereClause;

    $bookResult = mysqli_query($conn, $bookQuery);
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

.dropdown-container {
         margin-bottom: 20px;
}

.dropdown-container select {
         padding: 10px;
         font-size: 16px;
         border: 1px solid #ccc;
         border-radius: 4px;
}

.dropdown-container input[type="submit"] {
         border: none;
         color: white;
         padding: 10px 20px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         border-radius: 4px;
         background-color: #4CAF50;
         cursor: pointer;
}

.dropdown-container {
         margin-bottom: 20px;
      }

.dropdown-container label {
         display: block;
         font-size: 18px;
         margin-bottom: 5px;
         font-weight: bold;
         color: #333;
         /* Additional label styles */
         background-color: #f5f5f5;
         padding: 8px 12px;
         border-radius: 4px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dropdown-container select {
         padding: 10px;
         font-size: 16px;
         border: 1px solid #ccc;
         border-radius: 4px;
}

.dropdown-container input[type="submit"] {
         border: none;
         color: white;
         padding: 10px 20px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         border-radius: 4px;
         background-color: #4CAF50;
         cursor: pointer;
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

   <h1 class="title">Categories</h1>

   <div class="dropdown-container">
         <form method="POST" action="">
            <label for="genre">Select Genre:</label>
            <select name="genre" id="genre">
               <option value="">All Genres</option>
               <?php while ($genre = mysqli_fetch_assoc($genreResult)): ?>
                  <option value="<?php echo $genre['genre_name']; ?>"><?php echo $genre['genre_name']; ?></option>
               <?php endwhile; ?>
            </select>

            <label for="author">Select Author:</label>
            <select name="author" id="author">
               <option value="">All Authors</option>
               <?php while ($author = mysqli_fetch_assoc($authorResult)): ?>
                  <option value="<?php echo $author['name']; ?>"><?php echo $author['name']; ?></option>
               <?php endwhile; ?>
            </select>
             <br><br>
            <input type="submit" value="Filter">
         </form>
      </div>

   <div class="card">
   <div class="card-body">
   
   <?php if (isset($bookResult) && mysqli_num_rows($bookResult) > 0): ?>
      <?php while ($fetch_books = mysqli_fetch_assoc($bookResult)): ?>
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
            <div class="name"><p style="color:black;font-size:20px;"><b>Name: </b><?php echo $fetch_books['name']; ?></p></div>
            <div class="author"><p style="color:black;font-size:15px;"><b>Author: </b><?php echo $fetch_books['author']; ?></p></div>
            <div class="genre"><p style="color:black;font-size:15px;"><b>Genre: </b><?php echo $fetch_books['genre']; ?></p></div>
            </div>
            <br>
            <div class="book-description">
               <p><?php echo $fetch_books['description']; ?></p>
            </div>
            </div>
            </div>
            <button class=' button button1'>
               <a href="review.php?book_id=<?php echo $fetch_books['id']; ?>" class="review-button">Review</a>
            </button>
         </div>
         </div>
      <?php endwhile; ?>
   <?php else: ?>
      <p class="empty">No books found for the selected criteria.</p>
   <?php endif; ?>

   </div>
   </div>

</section>




<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
