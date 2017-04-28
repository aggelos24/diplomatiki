<meta charset="utf-8" />
<?php
$greek_alphabet = array ("α", "ά", "β", "γ", "δ", "ε", "έ", "ζ", "η", "ή", "θ", "ι", "ί", "κ", "λ", "μ", "ν", "ξ", "ο", "ό", "π", "ρ", "σ", "τ", "υ", "ύ", "φ", "χ", "ψ", "ω", "ώ", "ς",
"Α", "Ά", "Β", "Γ", "Δ", "Ε", "Έ", "Ζ", "Η", "Ή", "Θ", "Ι", "Ί", "Κ", "Λ", "Μ", "Ν", "Ξ", "Ο", "Ό", "Π", "Ρ", "Σ", "Τ", "Υ", "Ύ", "Φ", "Χ", "Ψ", "Ω", "Ώ");
$latin_repl = array ("a", "a", "b", "g", "d", "e", "e", "z", "i", "i", "th", "i", "i", "k", "l", "m", "n", "x", "o", "o", "p", "r", "s", "t", "u", "u", "f", "x", "ps", "o", "o", "s",
"A", "A", "B", "G", "D", "E", "E", "Z", "I", "I", "Th", "I", "I", "K", "L", "M", "N", "X", "O", "O", "P", "R", "S", "T", "Y", "Y", "F", "X", "Y", "O", "O");
$ok = 1;
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 			//απόπειρα σύνδεσης στη βάση
if (!$link) {										//αν αποτυχία
	$ok = 0;
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$target_file = "../material/".basename($_FILES["file"]["name"]);			//ορισμός διεύθυνσης προορισμού του αρχείου
$target_file = str_replace($greek_alphabet, $latin_repl, $target_file);			//αντικατάσταση ελληνικών χαρακτήρων με λατινικών
$result = $link->query ("SELECT * FROM material where path='".$target_file."'");	//έλεγχος αν υπάρχει αρχείο με αυτό το όνομα
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {				//αν υπάρχει
	$ok = 0;
	$result->free();
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Υπάρχει αρχείο με αυτό το όνομα.'); location.href = 'material.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
}
if ($ok) {
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {		//απόπειρα μετακίνησης αρχείου στην διεύθυνση προορισμού
		chmod($target_file, 0777);
		$link->query ("INSERT INTO material (path, description) VALUES ('".$target_file."', '".$_POST["description"]."')");
											//αν επιτυχία, εισαγωγή στον πίνακα material
		$result->free();
		$link->close();								//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Το αρχείο ανέβηκε.'); location.href = 'material.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
	}
	else {										//αν αποτυχία
		$result->free();
		$link->close();								//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
	}
}
?>
