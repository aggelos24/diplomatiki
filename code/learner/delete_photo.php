<meta charset="utf-8" />
<?php
session_start();																						//δημιουργία συνεδρίας
$link = mysqli_connect("localhost", "root", "", "diplomatiki"); 										//απόπειρα σύνδεσης στη βάση
if (!$link) {																							//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";					//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if (!(isset($_SESSION["session_lphoto"]))) {															//αν δεν υπάρχει φωτογραφία
		$link->close();																					//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχει φωτογραφία.'); location.href = 'lhome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
if (!unlink($_SESSION["session_lphoto"])) {																//απόπειρα διαγραφής εικόνας, αν αποτυχία
		$link->close();																					//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$link->query ("UPDATE user SET photo=NULL WHERE username='".$_SESSION["session_lusername"]."'");		//ενημέρωση του πίνακα user
$_SESSION["session_lphoto"] = NULL;																		//ενημέρωση μεταβλητής συνεδρίας
$link->close();																							//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εικόνα διαγράφηκε.'); location.href = 'lhome.php'; </script>";					//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
?>