<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 						//απόπειρα σύνδεσης στη βάση
if (!$link) {													//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'login_register_form.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT username FROM user where username='".$_POST["username"]."'");			//έλεγχος αν το όνομα χρήστη υπάρχει ήδη στη βάση
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {							//αν υπάρχει
	$result->free();
	$link->close();												//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το Όνομα Χρήστη υπάρχει ήδη, παρακαλώ επίλεξε άλλο.'); location.href = 'login_register_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
else {														//αν δεν υπάρχει
	$link->query ("INSERT INTO user (username, password, professor, level, photo, email, description, last_login) VALUES ('".$_POST["username"]."', '".md5($_POST["password"])."', DEFAULT, DEFAULT, DEFAULT, '".$_POST["email"]."', DEFAULT, DEFAULT)");
														//εισαγωγή στοιχείων χρήστη στον πίνακα user
	$result->free();
	$link->close();												//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Εγγράφηκες επιτυχώς, τωρά μπορείς να συνδεθείς.'); location.href = 'login_register_form.php'; </script>";	
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
?>
