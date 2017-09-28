<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();									//δημιουργία συνεδρίας
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);			//για αποφυγή σφάλματος βάσης
if (isset($_GET["id"])) {								//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];								//ανάθεση της σε μεταβλητή
}
else {											//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	exit();										//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");				//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("INSERT INTO group_chat (id, project_id, user, text) VALUES (DEFAULT, ".$id.", '".$_SESSION["session_lusername"]."', '".$message_text."')");
											//εισαγωγή μηνύματος στον πίνακα group_chat
$link->close();										//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
?>
