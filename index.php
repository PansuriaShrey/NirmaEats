<?php
    require('db.php');
    $conn=$con;

    $tempsql="SELECT * FROM `user`";
    $users=mysqli_query($conn,$tempsql);
    $users=mysqli_num_rows($users);

    $tempsql="SELECT * FROM `restaurant`";
    $restaurants=mysqli_query($conn,$tempsql);
    $restaurants=mysqli_num_rows($restaurants);

    $tempsql="SELECT * FROM `bill`";
    $bill=mysqli_query($conn,$tempsql);
    $bill=mysqli_num_rows($bill);

    $tempsql="SELECT * FROM `dish`";
    $dish=mysqli_query($conn,$tempsql);
    $dish=mysqli_num_rows($dish);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="assets/images/icon2.jpeg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=RocknRoll+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/index.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/index2.css">

    <title>Home</title>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="Logo" style="max-height:60px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- <div class="container mb-4 mt-4">
        <h1 class="has-animation animation-ltr text-uppercase" data-delay="10">Welcome to NirmaEats.</h1>
    </div> -->

    <div class="has-animation animation-ltr" data-delay="10">
        <h1 class="bigger text-light">Welcome to NirmaEats </h1>
    </div>

    <!-- <div class="container mt-0 mb-0 d-flex justify-content-center"> -->
        <div class="container mt-0 mb-0 d-flex justify-content-center w-100">
            <form action="login.php">
                <button class="btn btn-danger mb-3 btn-lg">
                    LogIn/SignUp as User
                </button>
            </form>
        </div>
        <div class="container mt-0 mb-0 d-flex justify-content-center w-100">
            <form action="login_restaurant.php">
                <button class="btn btn-danger mb-3 btn-lg">
                    LogIn/SignUp as Restaurant
                </button>
            </form>
        </div>
    <!-- </div> -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts section-bg">
            <div>
                <!-- <h5 class="mt-1 mb-1">Strengthing the Relation between Customers and Restaurants</h5> -->
                <h4 class="mt-1 mb-1 text-uppercase font-weight-bold" style="color: lavenderblush; font-size: 2rem;">Get the food you want</h4>
            </div>
        <br>
      <div class="container" style="margin-top: 5vh; margin-bottom: 1vh;">
        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo $users;?>" data-purecounter-duration="1"  class="purecounter"></span>
            <p>Customers</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo $restaurants;?>" data-purecounter-duration="50" class="purecounter"></span>
            <p>Restaurants</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo $bill;?>" data-purecounter-duration="50" class="purecounter"></span>
            <p>Orders Placed</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo $dish;?>" data-purecounter-duration="50" class="purecounter"></span>
            <p>Total Dishes </p>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script  src="assets/js/demo.js"></script>
<script src="assets/js/counter.js"></script>

</body>


</html>