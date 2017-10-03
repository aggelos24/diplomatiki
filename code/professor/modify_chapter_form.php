<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Επεξεργασία Κεφαλαίου </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
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
include "if_not_logged_p.php";										//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
if ((isset($_GET["chapter"])) and (isset($_GET["section"]))) {						//αν υπάρχουν οι μεταβλητές GET
	$chapter = $_GET["chapter"];									//ανάθεσή σε μεταβλητές
	$section = $_GET["section"];
}
else {													//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
echo "<span class='big'> <a href='show_chapter.php?section=".$section."&chapter=".$chapter."'> Προβολή </a> | Επεξεργασία </span> <br> <br>";
$i = 0;
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM chapter WHERE section_number=".$section." AND number=".$chapter);
													//ανάκτηση στοιχείων κεφαλαίου από τον πίνακα chapter
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (empty($row)) {											//αν δεν υπάρχει το κεφάλαιο
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
	exit();												//τερματισμός script
}
else {
	$title = $row["title"];
	$text = $row["text"];
	$image = $row["image"];
	if ($row["youtube"] != NULL) {
	$youtube = str_replace('"', "'", $row["youtube"]);						//για την σωστή εμφάνιση του κώδικα html
	}
	else {
		$youtube = "";
	}
}
?>
		<form method="post" action="modify_chapter.php">
			Αριθμός Ενότητας <input type="number" name="section_number" value="<?php echo $section; ?>" readonly /> <br>
			Αριθμός Κεφαλαίου <input type="number" name="chapter_number" value="<?php echo $chapter; ?>" readonly /> <br>
			Τίτλος Κεφαλαίου <input type="text" name="title" value="<?php echo $title; ?>" required /> <br>
<?php
$result = $link->query("SELECT path FROM material");							//ανάκτηση διεύθυνσης αρχείων από τον πίνακα material 
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε αρχείο
	if ($i == 0) {											//εμφάνισή του αρχείου ως επιλογή
		echo "Εικόνα που θα προβάλλεται στο κεφάλαιο <select name='image'>";
		if ($image == NULL) {
			echo "<option value=''></option>";
		}
		else {
			echo "<option value='".$image."'> ".$image." </option>";
			echo "<option value=''></option>";
		}
	}
	if ($row["path"] != $image) {
		echo "<option value='".$row["path"]."'> ".$row["path"]." </option>";
	}
	$i++;
}
if ($i == 0) {
	echo "Δεν έχεις προσθέσει υλικό ακόμα <br>";
}
else {
	echo "</select> <span class='red_letters'> (πάτησε την κενή επιλογή αν δεν θες να προσθέσεις εικόνα) </span> <br>";
}
?>
			Youtube βίντεο (αντέγραψε τον html κώδικα από την Ενσωμάτωση)
			<input type="text" name="youtube" value="<?php echo $youtube; ?>"/> (προαιρετικό) <br>
			Κείμενο Κεφαλαίου <br>
			<textarea name="chapter_text" rows="25" cols="100" class="form_chapter_text"><?php echo $text; ?></textarea> <br>
			<button type="submit"> Επεξεργασία </button>
		</form>

	</div>
</body>
</html>
