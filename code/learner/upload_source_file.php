<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();										//δημιουργία συνεδρίας
$greek_alphabet = array ("α", "ά", "β", "γ", "δ", "ε", "έ", "ζ", "η", "ή", "θ", "ι", "ί", "κ", "λ", "μ", "ν", "ξ", "ο", "ό", "π", "ρ", "σ", "τ", "υ", "ύ", "φ", "χ", "ψ", "ω", "ώ", "ς",
"Α", "Ά", "Β", "Γ", "Δ", "Ε", "Έ", "Ζ", "Η", "Ή", "Θ", "Ι", "Ί", "Κ", "Λ", "Μ", "Ν", "Ξ", "Ο", "Ό", "Π", "Ρ", "Σ", "Τ", "Υ", "Ύ", "Φ", "Χ", "Ψ", "Ω", "Ώ");
$latin_repl = array ("a", "a", "b", "g", "d", "e", "e", "z", "i", "i", "th", "i", "i", "k", "l", "m", "n", "x", "o", "o", "p", "r", "s", "t", "u", "u", "f", "x", "ps", "o", "o", "s",
"A", "A", "B", "G", "D", "E", "E", "Z", "I", "I", "Th", "I", "I", "K", "L", "M", "N", "X", "O", "O", "P", "R", "S", "T", "Y", "Y", "F", "X", "Y", "O", "O");
if (isset($_GET["id"])) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];									//ανάθεσή της σε μεταβλητή
}
else {												//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	exit();											//τερματισμός script
}
$link = connect_to_database("project.php?id=".$id);						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$target_file = "../projects/project_".$id."/".basename($_FILES["file"]["name"]);		//ορισμός διεύθυνσης προορισμού του αρχείου
$target_file = str_replace($greek_alphabet, $latin_repl, $target_file);				//αντικατάσταση ελληνικών χαρακτήρων με λατινικών
$result = $link->query ("SELECT * FROM source_file where path='".$target_file."'");		//έλεγχος αν υπάρχει αρχείο με αυτό το όνομα
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {					//αν υπάρχει
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Υπάρχει αρχείο με αυτό το όνομα.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	exit();											//τερματισμός script
}
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {				//απόπειρα μετακίνησης αρχείου στην διεύθυνση προορισμού
	chmod($target_file, 0777);
	$link->query ("INSERT INTO source_file (id, project_id, user, path, description) VALUES (DEFAULT, ".$id.", '".$_SESSION["session_lusername"]."', '".$target_file."', '".$_POST["description"]."')");
												//αν επιτυχία, εισαγωγή στον πίνακα source_file
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το αρχείο ανέβηκε.'); location.href = location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
else {												//αν αποτυχία
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
?>
