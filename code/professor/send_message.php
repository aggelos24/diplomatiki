<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$professor_username = "aggelos24";								//ανάθεση του username του καθηγητή σε μεταβλητή
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);				//για αποφυγή σφάλματος βάσης
if (($_GET["from"] == "phome") or ($_GET["from"] == "message")) {				//αν η μεταβλητή GET έχει κάποια τις δύο τιμές
    $from = $_GET["from"].".php";								//ανάθεσή της σε μεταβλητή
}
else {												//αν όχι
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'phome.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
    exit();											//τερματισμός script
}
$link = connect_to_database($from);								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT username FROM user where username='".$_POST["to_user"]."'");	//έλεγχος αν το όνομα χρήστη υπάρχει ήδη στη βάση
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {						//αν υπάρχει
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει μαθητής με αυτό το Όνομα Χρήστη.'); location.href = '".$from."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στην προηγούμενη σελίδα
}
else {
	$link->query ("INSERT INTO message (id, from_user, to_user, subject, text, seen, date) VALUES (DEFAULT, '".$professor_username."', '".$_POST["to_user"]."', '".$_POST["subject"]."', '".$message_text."', DEFAULT, NOW())");
												//δημιουργία μηνύματος στη βάση
	$result->free();
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = '".$from."'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στην προηγούμενη σελίδα
}
?>
