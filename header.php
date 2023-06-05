<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">


   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">BestBooks</a>

         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="books.php">Books</a>
            <a href="category.php">Catagory</a>
            <a href="contact.php">Contact</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search" style="font-size:1vw">Search Books</a>
            <div id="user-btn" class="fas fa-user" style="font-size:1vw">Profile</div>
           
         </div>

         <div class="user-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      </div>
   </div>

</header>