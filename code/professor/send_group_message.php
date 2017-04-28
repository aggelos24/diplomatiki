<meta charset="utf-8" />
<?php
$search = array("'", '"');
$replace = array("\'", '\"');
$message_text = str_replace($search, $replace, $_POST["message_text"]);				//για αποφυγή σφάλματος βάσης
if (isset($_GET["id"])) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];									//ανάθεσή της σε μεταβλητή
}
else {												//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 				//απόπειρα σύνδεσης στη βάση
if (!$link) {											//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("INSERT INTO group_chat (id, project_id, user, text) VALUES (DEFAULT, ".$id.", 'aggelos24', '".$message_text."')");
												//εισαγωγή μηνύματος στον πίνακα group_chat
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το μήνυμα στάλθηκε.'); location.href = 'project.php?id=".$id."'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
?>
