<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_l.php";									//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
if ((isset($_GET["chapter"])) and (isset($_GET["section"]))) {					//αν υπάρχουν οι μεταβλητές GET
	$chapter = $_GET["chapter"];								//ανάθεση σε μεταβλητές
	$section = $_GET["section"];
}
else {												//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();											//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM chapter WHERE section_number=".$section." AND number=".$chapter);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (!empty($row)) {										//αν υπάρχει
	echo "<title>".$row["title"]."</title>";						//εμφάνιση του κεφαλαίου
	echo "<span class='big'>".$row["section_number"].".".$row["number"]." ".$row["title"]."</span>";
	echo "<hr> <br>";
	$text = "<p class='text'>".$row["text"]."</p>";						//προσθήκη html tags για να φαίνεται όπως πρέπει στην σελίδα
	$text = str_replace("\n", "\n</p> <p class='text'>", $text);
	if (($row["image"] == NULL) and ($row["youtube"] == NULL)) {
		echo $text;
	}
	else if ($row["image"] == NULL) {
		echo $text."<br> <br>";
		echo $row["youtube"];
	}
	else {
		$result = $link->query("SELECT * FROM chapter INNER JOIN material ON chapter.image=material.path WHERE section_number=".$section." AND number=".$chapter);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$output = "<div class='container'> <div class='chapter_image_left'> <img src='".$row["image"]."' class='chapter_image'>".
				"<p class='center'>".$row["description"]."</p> </div> <div class='chapter_text'>".
				$text."</div> </div> <br>";
		echo $output;
		if ($row["youtube"] != NULL) {
			echo $row["youtube"]."<br>";
		}
	}
}
else {												//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$result->free();
$link->close();										//κλείσιμο σύνδεσης με βάση
?>
		<br> <br> <a href="history.php"> Επιστροφή </a>
	</div>
</body>
</html>
