<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $bookId = $_POST['book_id'];
    $username = $_SESSION['user_name']; // Assuming you store the logged-in user's username in a session variable
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $postDate = date('Y-m-d');

    // Insert the review into the database
    $insertQuery = "INSERT INTO review (reviewer_name, book_id, comment, rating, date_posted) VALUES ('$username',$bookId, '$comment', $rating, '$postDate')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        echo "Review submitted successfully.";
    } else {
        echo "Error submitting the review.";
    }
    header("Location: review.php?book_id=$bookId");

}

// Close database connection

?>
