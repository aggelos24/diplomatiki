<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$search = array('width="560" height="315"', "'", '"');
$replace = array('class="resp_iframe"', "\'", '\"');
$chapter_text = str_replace($search, $replace, $_POST["chapter_text"]);				//για αποφυγή σφάλματος βάσης
if (!empty($_POST["youtube"])) {								//αν δεν είναι κενό το πεδίο youtube
	$youtube = str_replace($search, $replace, $_POST["youtube"]);
}
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM section WHERE number=".$_POST["section_number"]);		//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό στον πίνακα section
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {						//αν δεν υπάρχει
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει ενότητα με αυτό τον αριθμό.'); location.href = 'insert_chapter_form.php'; </script>";	
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_chapter_form.php
	exit();											//τερματισμός script
}
$result = $link->query("SELECT * FROM chapter WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
												//έλεγχος αν υπάρχει κεφάλαιο με αυτό τον αριθμό στον πίνακα chapter
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {					//αν υπάρχει
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Υπάρχει ήδη κεφάλαιο με αυτό τον αριθμό.'); location.href = 'insert_chapter_form.php'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_chapter_form.php
	exit();											//τερματισμός script
}
$link->query("INSERT INTO chapter (section_number, number, title, text, image, youtube) VALUES (".$_POST["section_number"].", ".$_POST["chapter_number"].", '".$_POST["title"]."', '".$chapter_text."', DEFAULT, DEFAULT)");
												//εισαγωγή κεφαλαίου στον πίνακα chapter
if (!empty($_POST["image"])) {									//αν δεν έχει αφήσει το πεδίο image κενό
	$link->query("UPDATE chapter SET image='".$_POST["image"]."' WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);	
												//ενημέρωση πεδίου image του πίνακα chapter
}
if (!empty($_POST["youtube"])) {								//αν δεν έχει αφήσει το πεδίο youtube κενό
	$link->query("UPDATE chapter SET youtube='".$youtube."' WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
												//ενημέρωση πεδίου youtube του πίνακα chapter
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το κεφάλαιο προστέθηκε.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
?>
