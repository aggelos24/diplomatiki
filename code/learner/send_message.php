<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("message.php");							//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);				//για αποφυγή σφάλματος βάσης
session_start();										//δημιουργία συνεδρίας
if ($_POST["to_user"] == "Καθηγητής") {								//αν ο παραλήπτης είναι ο καθηγητής
	$_POST["to_user"] = "aggelos24";
}
$link->query ("INSERT INTO message (id, from_user, to_user, subject, text, seen, date) VALUES (DEFAULT, '".$_SESSION["session_lusername"]."', '".$_POST["to_user"]."', '".$_POST["subject"]."', '".$message_text."', DEFAULT, NOW())");
												//δημιουργία μηνύματος στη βάση
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = 'message.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα message.php
?>
