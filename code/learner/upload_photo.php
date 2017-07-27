<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();											//δημιουργία συνεδρίας
$file_type = pathinfo(basename($_FILES["photo"]["name"]), PATHINFO_EXTENSION);				//εύρεση επέκτασης αρχείου
$target_file = "photos/".$_SESSION["session_lusername"].".".$file_type;					//ορισμός διεύθυνσης προορισμού του αρχείου
$check = getimagesize($_FILES["photo"]["tmp_name"]);							//απόπειρα εύρεσης μεγέθους εικόνας
if($check == false) {											//αν αποτυχία, σημαίνει πως δεν είναι εικόνα το αρχείο
	$ok = 0;
	echo "<script> alert('Το αρχείο που ανέβασες δεν είναι εικόνα.'); location.href = 'lhome.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
	exit();												//τερματισμός script
}
if (isset($_SESSION["session_lphoto"])) {								//αν υπάρχει φωτογραφία
	unlink($_SESSION["session_lphoto"]);								//διαγραφή υπάρχουσας εικόνας
}
$link = connect_to_database("lhome.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {					//απόπειρα μετακίνησης εικόνας στην διεύθυνση προορισμού
	chmod($target_file, 0777);
	$_SESSION["session_lphoto"]=$target_file;							//αν επιτυχία, ενημέρωση της μεταβλητής συνεδρίας
	$link->query("UPDATE user SET photo='".$target_file."' WHERE username='".$_SESSION["session_lusername"]."'");
													//ενημέρωση του πίνακα user
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Η εικόνα ανέβηκε.'); location.href = 'lhome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
else {													//αν αποτυχία
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
?>
