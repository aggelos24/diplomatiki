<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();												//δημιουργία συνεδρίας
if (!(isset($_SESSION["session_lphoto"]))) {									//αν δεν υπάρχει φωτογραφία
	echo "<script> alert('Δεν υπάρχει φωτογραφία.'); location.href = 'lhome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
	exit();													//τερματισμός script
}
if (!unlink($_SESSION["session_lphoto"])) {									//απόπειρα διαγραφής εικόνας, αν αποτυχία
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
	exit();													//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");							//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("UPDATE user SET photo=NULL WHERE username='".$_SESSION["session_lusername"]."'");			//ενημέρωση του πίνακα user
$_SESSION["session_lphoto"] = NULL;										//ενημέρωση μεταβλητής συνεδρίας
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εικόνα διαγράφηκε.'); location.href = 'lhome.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
?>
