<?php 
 
	 session_start();





if (!isset($_SESSION['id']) || $_SESSION['is_admin'] !== 'true') {
   
    header("Location: login.php"); 
    exit(); 
}
   

   include_once('config.php');

   $id = $_GET['id'];

   $sql = "SELECT * FROM activities WHERE id=:id";
   $selectUser = $conn->prepare($sql);
   $selectUser->bindParam(':id', $id);
   $selectUser->execute();

   $user_data = $selectUser->fetch();
	

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Edit Activity - HumanityConnect</title>
 	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 	 <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
  	
	<meta name="theme-color" content="#7952b3">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/site.webmanifest">
    <link rel="icon" type="image/ico"  href="images/favicon.ico">



  <style>
    .navbar-brand {
    background-color: #1877F2; 
    color: white !important; 
  }
  </style>
 </head>
 <body>
 
 <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color: #1877F2;">

  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
    <?php echo "Welcome Admin, " . $_SESSION['username']; ?>
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="adminLogout.php">Sign out</a>
    </div>
  </div>
</header>



<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="adminHome.php">
              <span data-feather="home"></span>
              <i class="bi bi-house-door-fill me-2"></i>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="adminDashboard.php">
              <span data-feather="home"></span>
              <i class="bi bi-speedometer me-2"></i>
              Dashboard
            </a>
          </li>
         
        </ul>

        
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Activities</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
         Events
          </button>
        </div>
      </div>

    

      <h2>Edit Activity Details</h2>
      <div class="table-responsive">
        
       <form action="update.php" method="post">
  <div class="form-floating">
    <input readonly="readonly" type="text" class="form-control" id="floatingInput" placeholder="id" name="id" value="<?php echo  $user_data['id'] ?>">
    <label for="floatingInput">ID</label>
  </div>

  <div class="form-floating">
    <input type="text" class="form-control" id="floatingInput" placeholder="activity_name" name="activity_name" value="<?php echo  $user_data['activity_name'] ?>">
    <label for="floatingInput">Activity Name</label>
  </div>
  <div class="form-floating">
    <input type="text" class="form-control" id="floatingInput" placeholder="Activity Description" name="activity_desc" value="<?php echo  $user_data['activity_desc'] ?>">
    <label for="floatingInput">Activity Description</label>
  </div>

  <div class="form-floating">
    <input type="text" class="form-control" id="floatingInput" placeholder="Activity Location" name="activity_location" value="<?php echo  $user_data['activity_location'] ?>">
    <label for="floatingInput">Activity Location</label>
  </div>
  <br>
  <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit1">Update</button>
  <a href="adminHome.php" class="w-100 btn btn-lg btn-secondary mt-2 text-center d-block">Go Back</a>
</form>



      </div>
    </main>
  </div>
</div>

	<script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>


 </body>
 </html>