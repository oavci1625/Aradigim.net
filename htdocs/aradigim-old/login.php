<?php
    require "navigator.php"
?>

<link rel="stylesheet" href="css/loginStyle.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="img/alogo.png" id="icon" alt="User Icon"  />
    </div>

    <!-- Login Form -->
    <form action="includes/login.inc.php" method="post">
      <input type="text" id="login" class="fadeIn second" name="mailuid" placeholder="E-mail / Username">
      <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="Password">
      <input type="submit" class="fadeIn fourth" name="login-submit">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>

  </div>
</div>

<?php
    require "footer.php"
?>   