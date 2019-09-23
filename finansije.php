<?php
session_start();
	if(!isset($_SESSION['id_korisnika'])){
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"  content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/index1.css" type="text/css"/>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <title>Finansije</title>
</head>

<body>
<!-- Navigacja -->
<div class="container" >
	<nav class="navbar  sticky-top navbar-expand-md navbar-dark" style="background-color:#1E90FF;">

	  <a class="navbar-brand" href="#">Panevropski Univerzitet APEIRON</a>
	  <!-- Toggler button -->
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<!-- Toggler ikonica-->
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <!-- Navbar linkovi -->
	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
		  <li class="nav-item">
			<a class="nav-link" href="index.php">Unos podataka</a>
		  </li>
		  <li class="nav-item ">
			<a class="nav-link" href="pretraga.php">Osnovni podaci</a>
		  </li>
		   <li class="nav-item">
			<a class="nav-link" href="predmeti.php">Predmeti</a>
		  </li>
		   <li class="nav-item active">
			<a class="nav-link" href="finansije.php">Finansije</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="odjava.php">Odjava</a>
		  </li>
		</ul>
	  </div>
	</nav>

<div class="wrapper" style="background-color: #C0C0C0; padding-bottom:40px;">
	<div class="container" style="text-align:center; padding: 50px; color:white;">
		<h5>Ispis informacija o finansijama</h5>
	</div>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input style="width: 25%; margin:auto; padding:5px 7px;" type="search" name="search_polje" placeholder="Unesite br. indeksa studenta.." />
		<button type="submit" name="search-submit" class="btn btn-primary">Pretrazi</button>
	</form>
	

<?php
	if(isset($_POST['search-submit'])){

		require_once 'database.php';

		if(empty($_POST['search_polje'])){
			header('Location: predmeti.php');
			exit();
		}else{
			$index=$_POST['search_polje'];
			
			$sql="SELECT br_indeksa, ime, prezime, duguje, potrazuje, broj_uplacenih, datum_zadnje_uplate
			FROM studenti 
			JOIN finansije ON 
			studenti.id_finansija=finansije.id_finansija 
			WHERE br_indeksa=?";

			$stmt=mysqli_stmt_init($connection);
			mysqli_stmt_prepare($stmt, $sql);
			mysqli_stmt_bind_param($stmt, 's', $index);
			mysqli_stmt_execute($stmt);

			$rezultat=mysqli_stmt_get_result($stmt);
			$brRedova=mysqli_num_rows($rezultat);

			if($brRedova==0){
				header('Location: predmeti.php?error=noresult');
			}else{
				echo '<div class="container" style="margin-top:60px; width:70%;">';
				echo '<table class="table table-bordered table-striped table-sm table-hover">';
					echo '<tr style="background-color:#A9A9A9;  color:white;">';
						echo '<th>Broj indeksa</th>';
						echo '<th>Ime</th>';
						echo '<th>Prezime</th>';
						echo '<th>Duguje</th>';
						echo '<th>Potrazuje</th>';
						echo '<th>Broj uplacenih</th>';
						echo '<th>Datum zadnje uplate</th>';

					echo '</tr>';
				
					while($red=mysqli_fetch_assoc($rezultat)){
						echo "<tr style='background-color:#F5F5F5'>";
							echo "<td>" .$red['br_indeksa'] ."</td>";
							echo "<td>" .$red['ime'] ."</td>";
							echo "<td>" .$red['prezime'] ."</td>";
							echo "<td>" .$red['duguje'] ."</td>";
							echo "<td>" .$red['potrazuje'] ."</td>";
							echo "<td>" .$red['broj_uplacenih'] ."</td>";
							echo "<td>" .$red['datum_zadnje_uplate'] ."</td>";
						}
					echo "</tr>";
					echo '</table>';
					echo '</div>';
				}

		}
	}
?>

</div>
</div>
</body>
</html>