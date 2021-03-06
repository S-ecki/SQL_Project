<?php
require_once('DatabaseHelper.php');
$database = new DatabaseHelper();

// search for specific muskel
// if not set -> $bezeichnung is NULL and select gives all -> always display all on first load of page
$bezeichnung = '';
if (isset($_GET['bezeichnung'])) {
    $bezeichnung = $_GET['bezeichnung'];
}

$mv = '';
if (isset($_GET['mv'])) {
    $mv = $_GET['mv'];
}

// greater or less than "gt/lt"
$action = '';
if (isset($_GET['Aktion'])) {
    $action = $_GET['Aktion'];
}


// fetch data from database
if($bezeichnung != '') { $muskel_array = $database->selectMuskel($bezeichnung); }                  // search by bezeichnung
else if($bezeichnung == '' && $mv != '') { $muskel_array = $database->selectMuskelMv($mv, $action); }  // search by mv with > or <
else { $muskel_array = $database->selectMuskel($bezeichnung); }        // show all

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Datenbank">
    <meta name="author" content="Simon Eckerstorfer">

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <title>Muskel Homepage </title>
</head>

<body>
<main>

<div class="d-flex" id="wrapper">

<!-- Sidebar -->
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">CRUD Operations</div>
    <div class="list-group list-group-flush">
        <a href="trainingIndex.php" class="list-group-item list-group-item-action bg-light">Training</a>
        <a href="tpIndex.php" class="list-group-item list-group-item-action bg-light">Trainingspartner</a>
        <a href="geraetIndex.php" class="list-group-item list-group-item-action bg-light">Geräte</a>
        <a href="muskelIndex.php" class="list-group-item list-group-item-action bg-light">Muskel</a>
        <a href="konditioniertIndex.php" class="list-group-item list-group-item-action bg-light">konditioniert</a>
    </div>
</div>

<!-- Page Content -->
<div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Show Tables
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="showStudio.php">Studio</a>
          <a class="dropdown-item" href="showTrainee.php">Trainee</a>
          <a class="dropdown-item" href="showTrainer.php">Trainer</a>
          <a class="dropdown-item" href="showUebung.php">Übung</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Github
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project/blob/main/ER/ER-Fitnessdatenbank.pdf">ER Diagramm</a>
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project/blob/main/ER/Anforderungsanalyse.pdf">Anforderungsanalyse</a>
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project/tree/main/SQL">SQL Scripts</a>
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project/tree/main/Java">Autofill Java Source</a>
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project/tree/main/PHP">Website Source</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="https://github.com/S-ecki/SQL_Project">Readme</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
$("#menu-toggle").click(function(e) {
e.preventDefault();
$("#wrapper").toggleClass("toggled");
});
</script>


  <div class="container-fluid">
  <!-- Add + Update + Delete Muskel -->
  <br>
  <h1>Muskel</h1>
  <br>

  <form method="get" action="muskelAddUpdateDelete.php"> 

      <!-- Choice -->
      <div class="form-group">
        <label for="Aktion"><h3>Create, Update or Delete Muskel</h3></label>
        <select class="form-control" id="Aktion" name="Aktion">
          <option value="add" title="Bezeichnung + MV benötigt - ID autogeneriert">Create</option>
          <option value="update" title="Bezeichnung + MV für bestehende ID geändert">Update</option>
          <option value="delete" title="Muskel mit MID wird gelöscht">Delete</option>
        </select>
      </div>

      <!-- Textfelder -->
      <div class="form-group row">
          <div class="col">
              <input type="number" class="form-control" placeholder="Muskel ID" name="mid">
          </div>
          <br>

          <div class="col">
              <input type="text" class="form-control" placeholder="Bezeichnung" name="bezeichnung">
          </div>
          <br>

          <div class="col">
              <input type="number" class="form-control" placeholder="Minimalvolumen" name="mv">
          </div>
      </div>


      <!-- Submit button -->
      <div>
          <button type="submit" class="btn btn-primary">
              Submit
          </button>
      </div>
  </form>
  <br>



  <br>
  <!-- Search Muskel -->
  <h3 title="Search for Bezeichnung OR MV (if both: Bezeichnung gets searched)">Search Muskel </h3>
  <form method="GET">

      <div>
          <input type="text" class="form-control" placeholder="Bezeichnung" name="bezeichnung" value='<? echo $bezeichnung; ?>'>
      </div>
      <br>

      <div class="input-group">
              <select class="form-control-6" name="Aktion">
                  <option value="gt">Greater or Equal</option>
                  <option value="lt">Less or Equal</option>
              </select>
            
          <input type="number" class="form-control input-lg" placeholder="Minimalvolumen" name="mv" value='<? echo $mv; ?>'>
      </div>



      <br>

      <div>
          <button type="submit" class="btn btn-primary">
              Search
          </button>
      </div>
  </form>


  <br>
  <!-- Search result -->
  <h3>Search Results</h3>
  <table class="table table-striped table-sm table-hover">
      <thead class="thead-dark">
      <tr>
          <th>Muskel ID</th>
          <th>Bezeichnung</th>
          <th>Minimalvolumen</th>       
      </tr>
      </thead>

      <?php foreach ($muskel_array as $muskel) : ?>
          <tr>
              <td><?php echo $muskel['M_ID']; ?>  </td>
              <td><?php echo $muskel['BEZEICHNUNG']; ?>  </td>
              <td><?php echo $muskel['MV']; ?>  </td>      
          </tr>
      <?php endforeach; ?>
  </table>
</div>
</main>
</body>
</html>