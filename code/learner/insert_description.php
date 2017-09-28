<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();										//δημιουργία συνεδρίας
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if (empty($_POST["description_text"])){								//αν το πεδίο της φόρμας κενό
	$_SESSION["session_ldescription"] = NULL;						//ενημέρωση μεταβλητής συνεδρίας
	$link->query("UPDATE user SET description=NULL WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση του πίνακα description
}
else {
	$link->query("UPDATE user SET description='".$_POST["description_text"]."' WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση του πίνακα description
	$_SESSION["session_ldescription"] = $_POST["description_text"];				//ενημέρωση μεταβλητής συνεδρίας
}
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η περιγραφή ενημερώθηκε.'); location.href = 'lhome.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
?>
