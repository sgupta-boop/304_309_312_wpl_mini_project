<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
  .header {
    background-color: #1e1e1e;
    color: #fff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }

  .header h1 {
    margin: 0;
    font-size: 24px;
    letter-spacing: 1px;
  }

  .header .logo {
    display: flex;
    justify-content: flex-end;
    align-items: center;
  }

  .header img {
    height: 50px; /* Increased logo size */
    width: 50px; /* Make width equal to height for circular effect */
    border-radius: 50%; /* Makes the image circular */
    object-fit: cover; /* Ensures the image doesn't stretch */
    margin-left: 20px;
  }

  .welcome {
    font-size: 16px;
    color: #ccc;
  }
</style>

<div class="header">
  <h1>CAR-TOGRAPHY</h1>
  <div class="welcome">
    <?php
    echo "Welcome, " . htmlspecialchars($_SESSION['user']);
    ?>
  </div>
  <div class="logo">
    <img src="download.jpg" alt="CAR-TOGRAPHY Logo">
  </div>
</div>
