<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup - HumanityConnect</title>
    <link rel="stylesheet" href="css/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">
</head>
  <body>

 
      <div class="container">
          <div class="form-box login">
              <form action="loginLogic.php" method="post">
                  <h1>Sign In</h1>
                  <div class="input-box">
                      <input type="text" placeholder="Username" name="username" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <div class="forgot-link">
                      <a href="#">Forgot Password?</a>
                  </div>
                  <button name="submit" type="submit" class="btn">Sign in</button>
                  <p>or sign in with social platforms</p>
                  <div class="social-icons">
                      <a href="#"><i class='bx bxl-google' ></i></a>
                      <a href="#"><i class='bx bxl-facebook' ></i></a>
                      <a href="#"><i class='bx bxl-github' ></i></a>
                      <a href="#"><i class='bx bxl-linkedin' ></i></a>
                  </div>
              </form>
          </div>

          <div class="form-box register">
              <form action="register.php" method="post">
                  <h1>Register</h1>
                   <div class="input-box">
                      <input type="text" placeholder="Name" name="name" required>
                      <i class='bx bxs-user'></i>
                  </div>
                   <div class="input-box">
                      <input type="text" placeholder="Surname" name="surname" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="text" placeholder="Username"  name="username" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="email" placeholder="Email" name="email" required>
                      <i class='bx bxs-envelope' ></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <button name="submit" type="submit" class="btn">Register</button>
                 
              </form>
          </div>

          <div class="toggle-box">
              <div class="toggle-panel toggle-left">
                <h1>HumanityConnect</h1> <br> <br>
                  <h1>Hello, Welcome!</h1>
                  <p>Don't have an account?</p>
                  <button class="btn register-btn">Register</button>
              </div>

              <div class="toggle-panel toggle-right">
                <h1>HumanityConnect</h1>  <br><br>
                  <h1>Welcome Back!</h1>
                  <p>Already have an account?</p>
                  <button class="btn login-btn">Sign in</button>
              </div>
          </div>
      </div>

      <script src="script/script1.js"></script>
  </body>
</html>