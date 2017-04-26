<meta charset="utf-8" />
<?php
if (isset($_GET["path"])) {																				//αν υπάρχει η μεταβλητή GET																											
	$path = $_GET["path"];																				//ανάθεσή της σε μεταβλητή
}
else {																									//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
}
$link = mysqli_connect("localhost", "root", "", "diplomatiki"); 										//απόπειρα σύνδεσης στη βάση
if (!$link) {																							//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if (!unlink($path)) {																					//απόπειρα διαγραφής αρχείου, αν αποτυχία
	$link->close();																						//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'material.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
}
$link->query ("DELETE FROM material WHERE path='".$path."'");											//διαγραφή εγγραφής από τον πίνακα material
$link->close();																							//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το αρχείο διαγράφηκε.'); location.href = 'material.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα material.php
?>