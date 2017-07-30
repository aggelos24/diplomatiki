<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$professor_username = "aggelos24";								//ανάθεση του username του καθηγητή σε μεταβλητή
session_start();										//δημιουργία συνεδρίας
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);				//για αποφυγή σφάλματος βάσης
if ($_POST["to_user"] == "Καθηγητής") {								//αν ο παραλήπτης είναι ο καθηγητής
	$to_user = $professor_username;
}
else {
	$to_user = $_POST["to_user"];
}
$link = connect_to_database("message.php");							//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("INSERT INTO message (id, from_user, to_user, subject, text, seen, date) VALUES (DEFAULT, '".$_SESSION["session_lusername"]."', '".$to_user."', '".$_POST["subject"]."', '".$message_text."', DEFAULT, NOW())");
												//δημιουργία μηνύματος στη βάση
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = 'message.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα message.php
?>
