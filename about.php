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
   <title>about</title>

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
      </style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Why Choose Us?</h3>
         <p>Choosing our book review website offers numerous benefits for avid readers and book enthusiasts. We pride ourselves on providing a platform that is both user-friendly and comprehensive, ensuring that our users have a seamless experience. Our website features a vast and diverse collection of books spanning various genres, ensuring that readers of all preferences can find something that piques their interest. Additionally, we have a dedicated community of passionate reviewers who contribute insightful and unbiased reviews, helping users make informed decisions about their next reading choice.</p>
      </div>

   </div>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>