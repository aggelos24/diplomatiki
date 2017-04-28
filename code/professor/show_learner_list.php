<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Λίστα μαθητών </title>
	<script>
		function logout() {						//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
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
<?php
include "if_not_logged_p.php";							//έλεγχος αν έχει συνδεθεί ο καθηγητής
if ((isset($_GET["sort"]))) {							//αν υπάρχει η μεταβλητή GET
	$sort = $_GET["sort"];							//ανάθεσή της σε μεταβλητή
}
else {
	$sort = "";
}
if ($sort == "level") {								//αν η ταξινόμηση είναι με βάση το επίπεδο μαθητή
	echo "Ταξινόμηση <a href='show_learner_list.php'> Κατά Όνομα Χρήστη </a> ή κατά επίπεδο μαθητή ή <a href='show_learner_list.php?sort=date'> Κατά ημερομηνία τελευταίας σύνδεσης </a>";
}
else if ($sort == "date") {							//αν η ταξινόμηση είναι με βάση την ημερομηνία τελευταίας σύνδεσης χρήστη
	echo "Ταξινόμηση <a href='show_learner_list.php'> Κατά Όνομα Χρήστη </a> ή <a href='show_learner_list.php?sort=level'> Κατά επίπεδο μαθητή </a> ή κατά ημερομηνία τελευταίας σύνδεσης";
}
else {										//αν δεν έχει οριστεί τύπος ταξινόμησης
	echo "Ταξινόμηση κατά Όνομα Χρήστη ή <a href='show_learner_list.php?sort=level'> Κατά επίπεδο μαθητή </a> ή <a href='show_learner_list.php?sort=date'> Κατά ημερομηνία τελευταίας σύνδεσης </a>";
}
?>
		<div class="list_container"> <br>
			<div class="list"> <b> Όνομα Χρήστη </b> </div>
			<div class="list"> <b> Email </b> </div>
			<div class="list"> <b> Επίπεδο (1-6) </b> </div>
			<div class="list"> <b> Τελευταία Είσοδος </b> </div>
		</div>
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 		//απόπειρα σύνδεσης στη βάση
if (!$link) {									//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'phome.php'; </script>";
										//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if ($sort == "level") {								//αν η ταξινόμηση είναι με βάση το επίπεδο
	$result = $link->query ("SELECT * FROM user WHERE professor=0 ORDER BY level");										//ανάκτηση στοιχείων μαθητών ταξινομημένα με βάση το επίπεδο από τον πίνακα user
}
else if ($sort == "date") {							//αν η ταξινόμηση είναι με βάση την ημερομηνία τελευταίας σύνδεσης χρήστη
	$result = $link->query ("SELECT * FROM user WHERE professor=0 ORDER BY last_login DESC");
										//ανάκτηση στοιχείων μαθητών ταξινομημένα με βάση την ημερομηνία τελευταίας σύνδεσης χρήστη από τον πίνακα user
}
else {										//αν δεν έχει οριστεί τύπος ταξινόμησης
	$result = $link->query ("SELECT * FROM user WHERE professor=0");	//ανάκτηση στοιχείων μαθητών από τον πίνακα user
}
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {			//για κάθε μαθητή
	echo "<div class='list_container'>";
	echo "<div class='list'>".$row["username"]."</div>"."<div class='list'> ".$row["email"]."</div>"."<div class='list'>".$row["level"]."</div>"."<div class='list'>".$row["last_login"]."</div>";
	echo "</div>";								//εμφάνιση στοιχείων χρήστη
}
$result->free();
$link->close();									//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
