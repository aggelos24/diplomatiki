<meta charset="utf-8" />
<?php
session_start();																															//δημιουργία συνεδρίας
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 																			//απόπειρα σύνδεσης στη βάση
if (!$link) {																																//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if (empty($_POST["description_text"])){																										//αν το πεδίο της φόρμας κενό																											
	$_SESSION["session_ldescription"] = NULL;																								//ενημέρωσε μεταβλητής συνεδρίας
	$link->query ("UPDATE user SET description=NULL WHERE username='".$_SESSION["session_lusername"]."'");									//ενημέρωση του πίνακα description
}
else {
	$link->query ("UPDATE user SET description='".$_POST["description_text"]."' WHERE username='".$_SESSION["session_lusername"]."'");		//ενημέρωση του πίνακα description
	$_SESSION["session_ldescription"]=$_POST["description_text"];																			//ενημέρωση μεταβλητής συνεδρίας
}
$link->close();																																//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η περιγραφή ενημερώθηκε.'); location.href = 'lhome.php'; </script>";													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
?>