<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Προβολή Κεφαλαίου </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_p.php";									//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
if ((isset($_GET["chapter"])) and (isset($_GET["section"]))) {					//αν υπάρχουν οι μεταβλητές GET
	$chapter = $_GET["chapter"];								//ανάθεση σε μεταβλητές
	$section = $_GET["section"];
}
else {												//αν δεν υπάρχουν
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
	exit();											//τερματισμός script
}
echo "<span class='big'> Προβολή | <a href='modify_chapter_form.php?section=".$section."&chapter=".$chapter."'> Επεξεργασία </a> </span> <br> <br>";
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM chapter WHERE section_number=".$section." AND number=".$chapter);
												//ανάκτηση στοιχείων κεφαλαίου από τον πίνακα chapter
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (!empty($row)) {										//αν υπάρχει το κεφάλαιο
	echo "<span class='big'>".$row["section_number"].".".$row["number"]." ".$row["title"]."</span>";
												//εμφάνιση του κεφαλαίου
	echo "<hr> <br>";
	$text = "<p class='text'>".$row["text"]."</p>";						//προσθήκη html tags για να φαίνεται όπως πρέπει στην σελίδα
	$text = str_replace("\n", "\n</p> <p class='text'>", $text);
	if (($row["image"] == NULL) and ($row["youtube"] == NULL)) {
		echo $text;
	}
	else if ($row["image"] == NULL) {
		echo $text."<br> <br>";
		echo "<div class='embedded_container'>".$row["youtube"]."</div>";
	}
	else {
		$result = $link->query("SELECT * FROM chapter INNER JOIN material ON chapter.image=material.path WHERE section_number=".$section." AND number=".$chapter);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$output = "<div class='container'> <div class='chapter_image_left'> <img src='".$row["image"]."' class='chapter_image'>".
				"<p class='center'>".$row["description"]."</p> </div> <div class='chapter_text'>".
				$text."</div> </div> <br>";
		echo $output;
		if ($row["youtube"] != NULL) {
			echo "<div class='embedded_container'>".$row["youtube"]."</div> <br>";
		}
	}
}
else {												//αν δεν υπάρχει το κεφάλαιο
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
		<br> <br> <a href="content.php"> Επιστροφή </a>
	</div>
</body>
</html>
