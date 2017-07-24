<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include "connect_to_database.php";
$link = connect_to_database("login_register_form.php");							//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT username FROM user where username='".$_POST["username"]."'");		//έλεγχος αν το όνομα χρήστη υπάρχει ήδη στη βάση
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {						//αν υπάρχει
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το Όνομα Χρήστη υπάρχει ήδη, παρακαλώ επίλεξε άλλο.'); location.href = 'login_register_form.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
else {													//αν δεν υπάρχει
	$link->query ("INSERT INTO user (username, password, professor, level, photo, email, description, last_login) VALUES ('".$_POST["username"]."', '".md5($_POST["password"])."', DEFAULT, DEFAULT, DEFAULT, '".$_POST["email"]."', DEFAULT, DEFAULT)");
													//εισαγωγή στοιχείων χρήστη στον πίνακα user
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Εγγράφηκες επιτυχώς, τωρά μπορείς να συνδεθείς.'); location.href = 'login_register_form.php'; </script>";	
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
?>
