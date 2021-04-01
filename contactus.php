<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=RocknRoll+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="assets/bootstrap/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/contact.css">
    <link rel="stylesheet" href="assets/styles/styles.css">

    <title>Contact Us</title>
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
                <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item active">
                <a class="nav-link" href="contactus.php">Contact Us<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
        
    <div class="container mt-4 mb-2">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">
                    <i class="bi bi-envelope-fill fa-10x "></i>
                    <h3>Contact Us</h3>
                    <h4>We would love to hear from you !</h4>
                </div>
            </div>
            <div class="col-md-9">
                <div class="contact-form">
                    <div class="form-group">
                    
                    <div class="col-sm-10">          
                        <div class="texts">First Name:</div>    
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-10">  
                        <div class="texts">Last Name:</div>        
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-10">
                        <div class="texts">Email Address:</div>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-10">
                        <div class="texts">Comments:</div>
                        <textarea class="form-control" rows="5" placeholder="comments" id="comment"></textarea>
                    </div>
                    </div>
                    <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2"></div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>


</html>