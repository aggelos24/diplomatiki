<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Εργασίες </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="active"> Εργασίες </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		<span class="big"> Δημιουργία εργασίας | <a href="project_list.php"> Προβολή λίστας εργασιών </a> </span> <br> <br>
		Προτείνεται να μπαίνουν στην ίδια ομάδα "καλοί" με "κακούς" μαθητές σύμφωνα με τις αρχές της συνεργατικής μάθησης
		<form method="post" action="insert_project.php">
			Τίτλος Εργασίας <input type="text" name="title" /> <br>
			Περιγραφής Εργασίας: <br>
			<textarea name="description_text" rows="8" cols="80"></textarea> <br>
			Διορία <input type="date" name="deadline" /> <br>
			Μαθητές (μπορείς να επιλέξεις όσους θες): <br>
<?php 
include "if_not_logged_p.php";										//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM user WHERE professor=0");						//ανάκτηση στοιχείων μαθητών από τον πίνακα user
while ($row = $result->fetch_array()) {									//για κάθε μαθητή
	echo "<input type='checkbox' name='users[]' value='".$row["username"]."' />".$row["username"]."(".$row["level"].") ";
													//εμφάνιση μαθητών ως επιλογών
}
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
?>
			<br> <button type="submit"> Εισαγωγή </button>
		</form>
	</div>
</body>
</html>
