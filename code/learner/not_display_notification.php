<meta charset="utf-8" />
<?php
session_start();											//δημιουργία συνεδρίας
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if ((isset($_GET["id"])) and (isset($_GET["id"]))) {							//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];										//ανάθεσή της σε μεταβλητή
}
else {													//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
	exit();												//τερματισμός script
}
$link->query("UPDATE notification SET display=0 WHERE id=".$id);					//ενημέρωση του πίνακα notification
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η ειδοποίηση δεν θα εμφανιστεί ξανά.'); location.href = 'notification.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
?>
