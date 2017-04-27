<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Διδακτικό υλικό </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function delete_material_file(path) {							//με το πάτημα του κουμπιού διαγραφή αρχείου
			location.href = "delete_material_file.php?path="+path;
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		<form method="post" action="upload_material_file.php" enctype="multipart/form-data">
			<input type="file" name="file" required /> <br>
			Περιγραφή <input type="text" name="description" /> <br>
			<button type="submit"> Πάτησε εδώ για να το ανεβάσεις </button> <br>
		</form> <br> <br>
		Λίστα ανεβασμένων αρχείων <br>
<?php
include "if_not_logged_p.php";										//έλεγχος αν έχει συνδεθεί ο καθηγητής
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 					//απόπειρα σύνδεσης στη βάση
if (!$link) {												//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT * FROM material");							//ανάκτηση πληροφοριών αρχείου από τον πίνακα material
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε αρχείο
	echo $row["path"]." \"".$row["description"]."\"<br>";						//εμφάνιση πληροφοριών αρχείου και κουμπί για διαγραφή
	echo "<button onclick='delete_material_file(\"".$row["path"]."\")'> Διαγραφή </button>";
	echo "<br> <br>";
}
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
?>
		<a href="content.php"> Επιστροφή </a>
	</div>
</body>
</html>
