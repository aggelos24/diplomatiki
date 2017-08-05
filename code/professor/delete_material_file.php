<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
if (isset($_GET["path"])) {										//αν υπάρχει η μεταβλητή GET
	$path = $_GET["path"];										//ανάθεσή της σε μεταβλητή
}
else {													//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
	exit();												//τερματισμός script
}
if (!unlink($path)) {											//απόπειρα διαγραφής αρχείου, αν αποτυχία
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
	exit();												//τερματισμός script
}
$link = connect_to_database("material.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("DELETE FROM material WHERE path='".$path."'");						//διαγραφή εγγραφής από τον πίνακα material
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το αρχείο διαγράφηκε.'); location.href = 'material.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
?>
