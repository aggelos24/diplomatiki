<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Εισαγωγή Κεφαλαίου </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
<?php
include "if_not_logged_p.php";									//έλεγχος αν έχει συνδεθεί ο καθηγητής
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 				//απόπειρα σύνδεσης στη βάση
if (!$link) {											//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$i = 0;
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
?>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		<form method="post" action="insert_chapter.php">
			Αριθμός Ενότητας <input type="number" name="section_number" required /> <br>
			Αριθμός Κεφαλαίου <input type="number" name="chapter_number" required /> <br>
			Τίτλος Κεφαλαίου <input type="text" name="title" required /> <br>
<?php
$result = $link->query ("SELECT path FROM material");						//ανάκτηση διεύθυνσης αρχείου από τον πίνακα material
while ($row = $result->fetch_array()) {								//για κάθε αρχείο
	if ($i == 0) {										//εμφάνιση αρχείων ως επιλογών
		echo "Εικόνα που θα προβάλλεται στο κεφάλαιο <select name='image'>";
		echo "<option value=''></option>";
	}
	echo "<option value='".$row["path"]."'> ".$row["path"]." </option>";
	$i++;
}
if ($i == 0) {
	echo "Δεν έχεις προσθέσει υλικό ακόμα <br>";
}
else {
	echo "</select> <span class='red_letters'> (πάτησε την κενή επιλογή αν δεν θες να προσθέσεις εικόνα) </span> <br>";
}
?>
			Youtube βίντεο (αντέγραψε τον html κώδικα από την Ενσωμάτωση) <input type="text" name="youtube" /> (προαιρετικό) <br>
			Κείμενο Κεφαλαίου: <br>
			<textarea name="chapter_text" rows="25" cols="100" class="form_chapter_text"></textarea> <br>
			<button type="submit"> Εισαγωγή </button>
		</form>
	</div>
</body>
</html>
