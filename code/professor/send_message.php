<meta charset="utf-8" />
<?php
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);														//για αποφυγή σφάλματος βάσης
session_start();																											//δημιουργία συνεδρίας
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 															//απόπειρα σύνδεσης στη βάση
if (!$link) {																												//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'phome.php'; </script>";										//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT username FROM user where username='".$_POST["to_user"]."'");								//έλεγχος αν το όνομα χρήστη υπάρχει ήδη στη βάση
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {																		//αν υπάρχει
	$result->free();
	$link->close();																											//κλείσιμο σύνδεσης με βάση																																					
	echo "<script> alert('Δεν υπάρχει μαθητής με αυτό το Όνομα Χρήστη.'); location.href = 'phome.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
else {
	$link->query ("INSERT INTO message (id, from_user, to_user, subject, text, seen, date) VALUES (DEFAULT, 'aggelos24', '".$_POST["to_user"]."', '".$_POST["subject"]."', '".$message_text."', DEFAULT, NOW())");
																															//δημιουργία μηνύματος στη βάση
	$result->free();
	$link->close();																											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = 'phome.php'; </script>";									//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
?>