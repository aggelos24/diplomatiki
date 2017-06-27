<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Διδακτικό περιεχόμενο </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function section() {									//με το πάτημα του κουμπιού εμφάνιση φόρμας
			document.getElementById("bsection").style.display = "none";
			document.getElementById("section").style.display = "inline";
		}
		
		function chapter() {									//με το πάτημα του κουμπιού εμφάνιση φόρμας
			document.getElementById("bchapter").style.display = "none";
			document.getElementById("chapter").style.display = "inline";
		}
		
		function insert_chapter_form() {							//με το πάτημα του κουμπιού εμφάνιση φόρμας εισαγωγής κεφαλαίου
			location.href = "insert_chapter_form.php";
		}
		
		function material() {									//με το πάτημα του κουμπιού μετάβαση στη σελίδα material.php
			location.href = "material.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="active"> Διδακτικό περιεχόμενο </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_p.php";										//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
$link = connect_to_database("phome.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT * FROM section");							//ανάκτηση ενοτήτων από τον πίνακα section
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε ενότητα
	echo "<b>".$row["number"].". ".$row["title"]."</b> <br>";			 		//εμφάνιση τίτλου ενότητας
	$result2 = $link->query ("SELECT * FROM chapter WHERE section_number=".$row["number"]);		//ανάκτηση κεφαλαίων για την δεδομένη ενότητα από τον πίνακα chapter
	while ($row2 = $result2->fetch_array()) {							//για κάθε κεφάλαιο
		echo $row2["section_number"].".".$row2["number"]." <a href='show_chapter.php?section=".$row2["section_number"]."&chapter=".$row2["number"]."'>".$row2["title"]."</a> <br>";
													//εμφάνιση τίτλου κεφαλαίου με σύνδεσμο για το κεφάλαιο
	}
	$result2->free();
}
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
?>
		<br> <span class="red_letters"> Για επεξεργασία κεφαλαίων πάτησε στον σύνδεσμο με το όνομα του κεφαλαίου από πάνω </span> <br>
		Για προσθήκη, μετονομασία, ή διαγραφή ενότητας <button onclick="section()" id="bsection"> Πάτησε εδώ </button> <br>
		<div id="section" class="not_displayed">
			<form method="post" action="insert_section.php"> <br>
				Αριθμός Ενότητας <input type="number" name="number" required /> <br>
				Τίτλος  <input type="text" name="title" required /> <br>
				<button type="submit"> Εισαγωγή </button> <br> <br>
			</form>
			<form method="post" action="delete_section.php"> <br>
				Αριθμός Ενότητας <input type="number" name="number" required /> <br>
				<button type="submit"> Διαγραφή </button> <br> <br>
			</form>
			<form method="post" action="modify_section.php"> <br>
				Αριθμός Ενότητας <input type="number" name="number" required /> <br>
				Τίτλος  <input type="text" name="title" required /> <br>
				<button type="submit"> Τροποποίηση </button> <br> <br>
			</form>
		</div>
		Για προσθήκη, ή διαγραφή κεφαλαίου <button onclick="chapter()" id="bchapter"> Πάτησε εδώ </button>
		<div id="chapter" class="not_displayed">
			<form method="post" action="delete_chapter.php"> <br>
				Αριθμός Ενότητας <input type="number" name="section_number" required /> <br>
				Αριθμός Κεφαλαίου <input type="number" name="chapter_number" required /> <br>
				<button type="submit"> Διαγραφή </button>
			</form>
			Για Προσθήκη Κεφαλαίου <button onclick="insert_chapter_form()"> Πάτησε εδώ </button>
		</div> <br>
		Για προσθήκη ή διαγραφή διδακτικού υλικού <button onclick="material()"> Πάτησε εδώ </button>
	</div>
</body>
</html>
