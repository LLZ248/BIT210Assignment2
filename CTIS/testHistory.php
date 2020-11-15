<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- CTIS CSS & JS-->
    <link rel="stylesheet" href="CTIS.css">
    <script src="CTIS.js"></script>
    <title>CTIS Test History</title>

    <!--Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
<?php
  session_start();
  include('config.php');
  if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
    // no username and usertype
    header("Location: http://localhost/CTIS");//back to login page
  }
  if(!($_SESSION['userType'] == 'Patient')){
    //not patient
    echo '<script>alert("You don\'t have permission to access this page");window.location.href="index.html";</script>';
  }
  ?>
    <nav class="navbar navbar-expand-lg bg-white navbar-light">
        <!-- Brand -->
            <a class="navbar-brand" href="#"><img src="picture/CTISlogo.png" width="70" height="70" alt=""></a>
        
      
        <!-- Toggler/collapsibe Button -->
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="testHistory.html">Test History</a>
            </li>
          </ul>
          <figure class="mr-3 mt-2">
          <img src="picture/user.png" alt="user" width = 50 />
          <figcaption>
             <?php
              echo $_SESSION['userID'];
            ?>
          </figcaption>
        </figure>
          <form action="functionPHP/logout.php">  
          <button type="submit" class="btn btn-danger">Log Out</button>
        </form>
        </div>
  </nav>
  <!--Header-->
  <h1 class="text-center text-white bg-primary display-4 m-0">Test History</h1>
  
  <!--Test table that display the details of the test that the patient has been taken-->
  <table id="patient-table" class="table table-striped table-bordered bg-white">
    <thead class="thead-dark">
      <tr>
        <th class="th-sm">TestID
        </th>
        <th class="th-sm">Date
        </th>
        <th class="th-sm">Patient Username
        </th>
        <th class="th-sm">Patient Type
        </th>
        <th class="th-sm">Symptoms
        </th>
        <th class="th-sm">Result Date
        </th>
        <th class="th-sm">Result
        </th>
        <th class="th-sm">Status
        </th>
      </tr>
    </thead>
   
    <tbody>
    <?php 
      $id = $_SESSION['userID'];
      $sql = "SELECT * from test where patUsername=:id";
      $query = $dbh -> prepare($sql);
      $query->bindParam(':id',$id,PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      if($query->rowCount() > 0)
       {
        foreach($results as $result)
        {
        ?> 
            <tr>
                <td><?php echo htmlentities($result->testID);?></td>
                <td><?php echo htmlentities($result->testDate);?></td>  
                <td><?php echo htmlentities($result->patUsername);?></td>
                <td><?php echo htmlentities($result->patType);?></td>  
                <td><?php echo htmlentities($result->symptoms);?></td>
                <td><?php echo htmlentities($result->resultDate);?></td>
                <td><?php echo htmlentities($result->result);?></td>   
                <td><?php echo htmlentities($result->status);?></td>  
            </tr>
    </tbody><?php }} ?>
  </table>
  <div class="container m-5"><br></div>


<!--CTIS Footer-->
<footer class="fluid-container text-center ctis-footer fixed-bottom bg-dark text-white">
  &copy;Covid Testing Information Center 2020
  <p class="mx-auto"><a href="contact.html" class="text-white float-left">Contact Us</a><a class="text-white float-right" href="#">Back to top</a></p>
</footer>

</body>
</html>